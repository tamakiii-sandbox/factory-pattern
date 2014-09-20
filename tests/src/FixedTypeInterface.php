<?php

namespace Concretehouse\Dp\Factory\Test;

use Phake;

/**
 * Test for fixed type factory interface.
 */
class FixedTypeInterfaceTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @test
     */
    public function canUse()
    {
        Phake::mock('Concretehouse\Dp\Factory\FixedTypeInterface');
    }
}
