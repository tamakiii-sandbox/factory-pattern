<?php

namespace Concretehouse\Dp\Factory\Test;

use Phake;

/**
 * Test for factory-injectable factory interface.
 */
class FactoryInjectableInterfaceTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @test
     */
    public function canUse()
    {
        Phake::mock('Concretehouse\Dp\Factory\FactoryInjectableInterface');
    }
}
