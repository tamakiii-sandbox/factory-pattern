<?php

namespace Concretehouse\Dp\Factory\Test\Concretes;

use Concretehouse\Dp\Factory\Concretes\Factory;
use Phake;

/**
 * Test for factory.
 */
class FactoryTest extends \PHPUnit_Framework_TestCase
{
    /**
     * Set up
     */
    public function setUp()
    {
        $this->functions = Phake::mock('Concretehouse\Dp\Factory\FunctionsInterface');
        $this->factory = new Factory($this->functions);
    }

    /**
     * @test
     */
    public function canMakeWithExistingClass()
    {
        $class = '\stdClass';
        $args = array('test');
        $std = new \stdClass;

        Phake::when($this->functions)
            ->newInstanceArgs($class, $args)
            ->thenReturn($std);

        $this->assertSame($std, $this->factory->make($class, $args));
    }

    /**
     * @test
     * @expectedException \ReflectionException
     */
    public function throwsExceptionIfNewInstanceArgsThrowsException()
    {
        Phake::when($this->functions)
            ->newInstanceArgs('Hoge', array())
            ->thenThrow(new \ReflectionException);

        $this->factory->make('Hoge');
    }

    /**
     * @test
     * @expectedException \UnexpectedValueException
     */
    public function throwsExceptionIfNewInstanceArgsReturnedNonObject()
    {
        Phake::when($this->functions)
            ->newInstanceArgs('Hoge', array())
            ->thenReturn(123456789);

        $this->factory->make('Hoge');
    }
}
