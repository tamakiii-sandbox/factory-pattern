<?php

namespace Concretehouse\Dp\Factory;

/**
 * Matchable factory interface.
 */
interface MatchableInterface extends FactoryInterface
{
    /**
     * @param string $interface
     * @return boolean
     */
    public function match($interface);
}
