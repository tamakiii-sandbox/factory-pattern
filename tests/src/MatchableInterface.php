<?php

namespace Concretehouse\Dp\Factory\Test;

use Phake;

/**
 * Test for matchable factory interface.
 */
class MatchableInterfaceTest extends \PHPUnit_Framework_TestCase
{
    /**
     * Set up
     */
    public function setUp()
    {
        $this->matchable = Phake::mock('Concretehouse\Dp\Factory\MatchableInterface');
    }

    /**
     * @test
     */
    public function implementsFactoryInterface()
    {
        $this->assertInstanceOf('Concretehouse\Dp\Factory\FactoryInterface', $this->matchable);
    }
}
