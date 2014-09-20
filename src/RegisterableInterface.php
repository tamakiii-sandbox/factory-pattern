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
     */
    public function register($name, $class);

    /**
     * @param array $list
     */
    public function registers(array $list);
}
