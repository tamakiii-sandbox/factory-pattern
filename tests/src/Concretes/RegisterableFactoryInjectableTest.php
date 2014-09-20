<?php

namespace Concretehouse\Dp\Factory\Test\Concretes;

use Concretehouse\Dp\Factory\Concretes\RegisterableFactoryInjectable;
use Concretehouse\Dp\Factory\MatchableInterface;
use Concretehouse\Dp\Factory\FactoryInterface;
use Phake;

interface MatchableFactoryInterface extends MatchableInterface, FactoryInterface {}

/**
 * Test for registerable & factory-injectable factory class.
 */
class RegisterableFactoryInjectableTest extends \PHPUnit_Framework_TestCase
{
    /**
     * Set up
     */
    public function setUp()
    {
        // Prepare factories mocks
        $this->factories = array(
            Phake::mock(__NAMESPACE__ . '\MatchableFactoryInterface'),
            Phake::mock(__NAMESPACE__ . '\MatchableFactoryInterface'),
            Phake::mock(__NAMESPACE__ . '\MatchableFactoryInterface'),
        );

        // prepare factories mocks return
        Phake::when($this->factories[0])->match(false);
        Phake::when($this->factories[1])->match(false);
        Phake::when($this->factories[2])->match(false);

        // Classes
        $this->classes = array(
            'hoge' => 'HogeClass',
            'fuga' => 'FugaClass',
            'vaa'  => 'VaaClass',
        );

        // Prepare functions mock
        $this->functions = Phake::mock('Concretehouse\Dp\Factory\FunctionsInterface');

        // Prepare registerable factory-injectable factory
        $this->factory = new RegisterableFactoryInjectable($this->functions);

        // Add factories
        foreach ($this->factories as $factory) {
            $this->factory->addFactory($factory);
        }

        // Add classes
        foreach ($this->classes as $name => $class) {
            $this->factory->register($name, $class);
        }
    }

    /**
     * @test
     */
    public function implementsFactoryInjectableIF()
    {
        $this->assertInstanceOf('Concretehouse\Dp\Factory\FactoryInjectableInterface', $this->factory);
    }

    /**
     * @test
     */
    public function extendsRegisterable()
    {
        $this->assertInstanceOf('Concretehouse\Dp\Factory\Concretes\Registerable', $this->factory);
    }

    /**
     * @test
     */
    public function canSetFactoriesFromCtor()
    {
        $std = new \stdClass;

        Phake::when($this->functions)->classImplements('FugaClass')->thenReturn(array('FugaInterface'));

        Phake::when($this->factories[1])->match('FugaInterface')->thenReturn(true);
        Phake::when($this->factories[1])->make('FugaClass', array())->thenReturn($std);

        $this->assertSame($std, $this->factory->make('fuga'));
    }

    /**
     * @test
     * @expectedException \PHPUnit_Framework_Error
     */
    public function throwsExceptionIfNonMAtchableInterfaceImplementedObjectSpecified()
    {
        $this->factory->addFactory(new \stdClass);
    }

    /**
     * @test
     * @expectedException \InvalidArgumentException
     */
    public function throwsExceptionIfNonFactoryInterfaceImplementedObjectSpecified()
    {
        $this->factory->addFactory(
            Phake::mock('Concretehouse\Dp\Factory\MatchableInterface')
        );
    }

    /**
     * @test
     * @expectedException \UnexpectedValueException
     */
    public function throwsExceptionIfMatchedClassHasNoIF()
    {
        Phake::when($this->functions)->classImplements('FugaClass')->thenReturn(false);
        $this->factory->make('fuga');
    }

    /**
     * @test
     * @expectedException \LogicException
     */
    public function throwsExceptionIfNoFactoryFound()
    {
        Phake::when($this->functions)->classImplements('FugaClass')->thenReturn(array('FugaInterface'));
        $this->factory->make('fuga');
    }
}
