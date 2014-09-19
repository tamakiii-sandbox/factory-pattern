<?php

namespace Concretehouse\Dp\Test\Unit\Concretes;

use Concretehouse\Dp\Factory\Concretes\Functions;
use Phake;

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
}
