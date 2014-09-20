<?php

namespace Concretehouse\Dp\Factory\Test;

use Phake;

/**
 * Test for matcher-injectable factory interface.
 */
class RegisterableFactoryInjectableTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @test
     */
    public function canUse()
    {
        Phake::mock('Concretehouse\Dp\Factory\MatcherInjectableInterface');
    }
}
