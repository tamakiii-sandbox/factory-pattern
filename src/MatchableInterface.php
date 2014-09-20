<?php

namespace Concretehouse\Dp\Factory;

/**
 * Matchable factory interface.
 */
interface MatchableInterface
{
    /**
     * @param string $interface
     * @return boolean
     */
    public function match($interface);
}
