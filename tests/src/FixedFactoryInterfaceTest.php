<?php

namespace Concretehouse\Dp\Factory\Test;

use Phake;

/**
 * Test for fixed-factory interface.
 */
class FixedFactoryInterface extends \PHPUnit_Framework_TestCase
{
    /**
     * @test
     */
    public function canImplement()
    {
        Phake::mock('Concretehouse\Dp\Factory\FixedFactoryInterface');
    }
}
