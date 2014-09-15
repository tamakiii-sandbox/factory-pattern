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
     * @return mixed
     */
    public function make($name, array $args = array());
}
