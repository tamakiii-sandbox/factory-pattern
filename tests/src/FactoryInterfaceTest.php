<?php

namespace Concretehouse\Dp\Factory\Test;

use Phake;

/**
 * Test for factory interface.
 */
class FactoryInterfaceTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @test
     */
    public function canImplement()
    {
        Phake::mock('Concretehouse\Dp\Factory\FactoryInterface');
    }
}
