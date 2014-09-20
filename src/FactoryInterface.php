<?php

namespace Concretehouse\Dp\Factory;

/**
 * Factory interface.
 */
interface FactoryInterface
{
    /**
     * @param string $name
     * @param array $args
     * @return object
     */
    public function make($name, array $args = array());
}
