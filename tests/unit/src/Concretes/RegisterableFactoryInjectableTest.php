<?php

namespace Concretehouse\Dp\Factory\Test\Unit\Concretes;

use Concretehouse\Dp\Factory\Concretes\RegisterableFactoryInjectable;
use Phake;

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
        // Prepare matcher mocks
        $this->matchers = array(
            Phake::mock('Concretehouse\Dp\Factory\MatchableInterface'),
            Phake::mock('Concretehouse\Dp\Factory\MatchableInterface'),
            Phake::mock('Concretehouse\Dp\Factory\MatchableInterface'),
        );

        // prepare matcher mocks return
        Phake::when($this->matchers[0])->match(false);
        Phake::when($this->matchers[1])->match(false);
        Phake::when($this->matchers[2])->match(false);

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
        foreach ($this->matchers as $matcher) {
            $this->factory->addFactory($matcher);
        }

        // Add classes
        foreach ($this->classes as $name => $class) {
            $this->factory->register($name, $class);
        }
    }

    /**
     * @test
     */
    public function implementsMatcherInjectableIF()
    {
        $this->assertInstanceOf('Concretehouse\Dp\Factory\MatcherInjectableInterface', $this->factory);
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
    public function canSetMatchersFromCtor()
    {
        $std = new \stdClass;

        Phake::when($this->functions)->classImplements('FugaClass')->thenReturn(array('FugaInterface'));

        Phake::when($this->matchers[1])->match('FugaInterface')->thenReturn(true);
        Phake::when($this->matchers[1])->makeByClass('FugaClass', array())->thenReturn($std);

        $this->assertSame($std, $this->factory->make('fuga'));
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
    public function throwsExceptionIfNoMatcherFound()
    {
        Phake::when($this->functions)->classImplements('FugaClass')->thenReturn(array('FugaInterface'));
        $this->factory->make('fuga');
    }
}
