<?php

namespace Concretehouse\Dp\Factory;

/**
 * Registerable factory interface.
 */
interface RegisterableInterface extends FactoryInterface
{
    /**
     * @param string $name
     * @param string $class
     * @param array $args
     */
    public function register($name, $class, array $args = array());

    /**
     * @param array $list
     */
    public function registers(array $list);
}
