<?php

namespace Concretehouse\Dp\Test\Concretes;

use Concretehouse\Dp\Factory\Concretes\Functions;
use Phake;

interface HInterface {}
interface HogeInterface {}

class HogeClass implements HInterface, HogeInterface {}
class FugaClass {}

/**
 * Test for functions-class for factory.
 */
class FunctionsClassTest extends \PHPUnit_Framework_TestCase
{
    /**
     * Set up
     */
    public function setUp()
    {
        $this->functions = new Functions;
    }

    /**
     * @test
     */
    public function implementsFunctionsIF()
    {
        $this->assertInstanceOf('Concretehouse\Dp\Factory\FunctionsInterface', $this->functions);
    }

    /**
     * @test
     */
    public function classImplementsReturnsImplementedInterfaces()
    {
        $ns = __NAMESPACE__;

        $interfaces = $this->functions->classImplements(__NAMESPACE__ . '\HogeClass');
        $this->assertSame(array(
            "{$ns}\HInterface" => "{$ns}\HInterface",
            "{$ns}\HogeInterface" => "{$ns}\HogeInterface",
        ), $interfaces);
    }

    /**
     * @test
     */
    public function classImplementsReturnsFalseIfNoInterface()
    {
        $this->assertSame(array(), $this->functions->classImplements(__NAMESPACE__ . '\FugaClass'));
    }

    /**
     * @test
     * @expectedException \PHPUnit_Framework_Error_Warning
     */
    public function classImplementsRaisesWarningIfClassNotFound()
    {
        $this->functions->classImplements(__NAMESPACE__ . '\VaaClass');
    }

    /**
     * @test
     */
    public function newInstanceArgsInstantiatesClassWithArgs()
    {
        $array = $this->functions->newInstanceArgs('\SplFixedArray', array(10));

        $this->assertInstanceOf('\SplFixedArray', $array);
        $this->assertSame(10, $array->getSize());
    }

    /**
     * @test
     */
    public function newInstanceArgsInstantiatesClassWithoutArgs()
    {
        $std = $this->functions->newInstanceArgs('\stdClass', array(10));

        $this->assertInstanceOf('\stdClass', $std);
    }
}
