<?php

namespace Concretehouse\Dp\Factory\Test\Concretes;

use Concretehouse\Dp\Factory\Concretes\Registerable;
use Phake;

/**
 * Test for registerable factory class.
 */
class RegisterableTest extends \PHPUnit_Framework_TestCase
{
    /**
     * Set up
     */
    public function setUp()
    {
        $this->std = new \stdClass;
        $this->array = new \SplFixedArray(10);

        $this->functions = Phake::mock('Concretehouse\Dp\Factory\FunctionsInterface');
        $this->factory = new Registerable($this->functions);

        $this->factory->register('std', '\stdClass');

        Phake::when($this->functions)
            ->newInstanceArgs('\stdClass', Phake::ignoreRemaining())
            ->thenReturn($this->std);

        Phake::when($this->functions)
            ->newInstanceArgs('\SplFixedArray', array(10))
            ->thenReturn($this->array);
    }

    /**
     * @test
     */
    public function implementsRegisterableInterface()
    {
        $this->assertInstanceOf('Concretehouse\Dp\Factory\RegisterableInterface', $this->factory);
    }

    /**
     * @test
     */
    public function canMakeWithRegisterMethod()
    {
        $this->factory->register('fixed_array', '\SplFixedArray');
        $this->assertSame($this->array, $this->factory->make('fixed_array', array(10)));
    }

    /**
     * @test
     */
    public function canMakeWithRegistersMethod()
    {
        $this->factory->registers(array(
            'std' => '\stdClass',
            'fixed_array' => '\SplFixedArray',
        ));

        $this->assertSame($this->std, $this->factory->make('std'));
        $this->assertSame($this->array, $this->factory->make('fixed_array', array(10)));
    }

    /**
     * @test
     */
    public function canMakeWithRegistersMethodWithArgs()
    {
        $this->factory->registers(array(
            'std' => array('\stdClass', array('a', 'b')),
        ));

        $this->assertSame($this->std, $this->factory->make('std'));
    }

    /**
     * @test
     */
    public function mergeDefaultArgsWithRegisters()
    {
        $this->factory->registers(array(
            'std' => array('\stdClass', array('a', 'b')),
        ));

        $this->assertSame($this->std, $this->factory->make('std', array('A')));

        Phake::verify($this->functions, Phake::times(1))
            ->newInstanceArgs('\stdClass', array('A', 'b'));
    }

    /**
     * @test
     */
    public function mergeDefaultArgsWithRegister()
    {
        $this->factory->register('std', '\stdClass', array('a', 'b'));

        $this->assertSame($this->std, $this->factory->make('std', array('A')));

        Phake::verify($this->functions, Phake::times(1))
            ->newInstanceArgs('\stdClass', array('A', 'b'));
    }

    /**
     * @test
     */
    public function canReplaceOldRegistration()
    {
        $array = new \SplFixedArray(10);

        Phake::when($this->functions)
            ->newInstanceArgs('\SplFixedArray', array(10))
            ->thenReturn($array);

        $this->factory->register('std', '\SplFixedArray');

        $this->assertSame($array, $this->factory->make('std', array(10)));
    }

    /**
     * test
     */
    public function canPassMultipleCtorArgs()
    {
        $exception  = new \Exception('Test', 100);

        Phake::when($this->functions)
            ->newInstanceArgs('\Exception', array('Test', 100))
            ->thenReturn($exception);

        $this->factory->register('exception', '\Exception');
        $this->assertSame($exception, $this->factory->make('exception', array('Test', 100)));
    }

    /**
     * @test
     * @expectedException \LogicException
     */
    public function throwsExceptionIfNotRegisterd()
    {
        $this->factory->make('undefined');
    }

    /**
     * @test
     * @expectedException \UnexpectedValueException
     */
    public function throwsExceptionIfNewInstanceArgsReturnedNull()
    {
        Phake::when($this->functions)
            ->newInstanceArgs('Null', array())
            ->thenReturn(null);

        $this->factory->register('null', 'Null');
        $this->factory->make('null');
    }

    /**
     * @test
     * @expectedException \UnexpectedValueException
     */
    public function throwsExceptionIfNewInstanceArgsReturnedNonObject()
    {
        Phake::when($this->functions)
            ->newInstanceArgs('String', array())
            ->thenReturn('hello, world');

        $this->factory->register('string', 'String');
        $this->factory->make('string');
    }
}
