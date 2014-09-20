<?php

namespace Concretehouse\Dp\Test;

use Phake;

/**
 * Test for functions-interface for factory.
 */
class FunctionsInterfaceTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @test
     */
    public function canUse()
    {
        Phake::mock('Concretehouse\Dp\Factory\FunctionsInterface');
    }
}
