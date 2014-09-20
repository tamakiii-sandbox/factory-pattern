<?php

namespace Concretehouse\Dp\Factory\Test\Concretes;

use Concretehouse\Dp\Factory\Concretes\RegisterableFixedType;
use Concretehouse\Dp\Factory\FactoryInterface;
use Concretehouse\Dp\Factory\FactoryInjectableInterface;
use Phake;


/**
 * Test for registerable fixed type factory class.
 */
class RegisterableFixedTypeTest extends \PHPUnit_Framework_TestCase
{
    /**
     * Set up
     */
    public function setUp()
    {
        $this->type = 'Concretehouse\Dp\Factory\FactoryInterface';
        $this->functions = Phake::mock('Concretehouse\Dp\Factory\FunctionsInterface');

        $this->list = array(
            'ok_1' => array(
                'class' => 'FactoryInterface',
                'mock' => Phake::mock('Concretehouse\Dp\Factory\FactoryInterface')
            ),
            'ok_2' => array(
                'class' => 'FactoryInjectableInterface',
                'mock' => Phake::mock('Concretehouse\Dp\Factory\FactoryInjectableInterface')
            ),
            'ng_1' => array(
                'class' => 'stdClass',
                'mock' => Phake::mock('\stdClass')
            ),
        );

        $this->factory = new RegisterableFixedType($this->type, $this->functions);
        foreach ($this->list as $name => $values) {
            $this->factory->register($name, $values['class']);
            Phake::when($this->functions)
                ->newInstanceArgs($values['class'], array())
                ->thenReturn($values['mock']);
        }
    }

    /**
     * @test
     */
    public function canGetType()
    {
        $this->assertSame($this->type, $this->factory->getType());
    }

    /**
     * @test
     */
    public function returnsSpecifiedTypeOfObject()
    {
        $this->assertSame($this->list['ok_1']['mock'], $this->factory->make('ok_1'));
        $this->assertSame($this->list['ok_2']['mock'], $this->factory->make('ok_2'));
    }

    /**
     * @test
     * @expectedException \UnexpectedValueException
     */
    public function throwsExceptionIfUnexpectedObjectWasGenerated()
    {
        $this->factory->make('ng_1');
    }
}
