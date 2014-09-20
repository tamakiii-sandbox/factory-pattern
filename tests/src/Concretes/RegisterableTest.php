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
        $this->functions = Phake::mock('Concretehouse\Dp\Factory\FunctionsInterface');

        $this->factory = new Registerable($this->functions);

        $this->factory->register('std', '\stdClass');
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
        $array = new \SplFixedArray(10);

        Phake::when($this->functions)
            ->newInstanceArgs('\SplFixedArray', array(10))
            ->thenReturn($array);

        $this->factory->register('fixed_array', '\SplFixedArray');
        $this->assertSame($array, $this->factory->make('fixed_array', array(10)));
    }

    /**
     * @test
     */
    public function canMakeWithRegistersMethod()
    {
        $std = new \stdClass;
        $array = new \SplFixedArray(10);

        Phake::when($this->functions)
            ->newInstanceArgs('\stdClass', array())
            ->thenReturn($std);

        Phake::when($this->functions)
            ->newInstanceArgs('\SplFixedArray', array(10))
            ->thenReturn($array);

        $this->factory->registers(array(
            'std' => '\stdClass',
            'fixed_array' => '\SplFixedArray',
        ));

        $this->assertSame($std, $this->factory->make('std'));
        $this->assertSame($array, $this->factory->make('fixed_array', array(10)));
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
}
