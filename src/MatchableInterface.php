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

    /**
     * @param string $class
     * @param array $args
     * @return mixed
     */
    public function makeByClass($class, array $args = array());
}
