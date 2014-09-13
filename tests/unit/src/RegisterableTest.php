<?php

namespace Concretehouse\Dp\Factory\Test\Unit;

use Concretehouse\Dp\Factory\Registerable;
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
        $this->factory = new Registerable(array(
            'std' => '\stdClass',
        ));
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
    public function canCreateWithRegisteredInConstructor()
    {
        $this->assertInstanceOf('\stdClass', $this->factory->create('std'));
    }

    /**
     * @test
     */
    public function canCreateWithRegisteredWithRegisterMethod()
    {
        $this->factory->register('fixed_array', '\SplFixedArray');
        $this->assertInstanceOf('\SplFixedArray', $this->factory->create('fixed_array'));
    }

    /**
     * @test
     */
    public function canReplaceOldRegistration()
    {
        $this->factory->register('std', '\SplFixedArray');
        $this->assertInstanceOf('\SplFixedArray', $this->factory->create('std'));
    }

    /**
     * @test
     */
    public function canPassSingleCtorArgs()
    {
        $this->factory->register('fixed_array', '\SplFixedArray');
        $object = $this->factory->create('fixed_array', array(10));

        $this->assertSame($object->count(), 10);
    }

    /**
     * @test
     */
    public function canPassMultipleCtorArgs()
    {
        $this->factory->register('exception', '\Exception');
        $object = $this->factory->create('exception', array('Test', 100));

        $this->assertSame('Test', $object->getMessage());
        $this->assertSame(100, $object->getCode());
    }
}
