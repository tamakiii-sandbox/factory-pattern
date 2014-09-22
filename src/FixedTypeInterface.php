<?php

namespace Concretehouse\Dp\Factory;

/**
 * Fixed type factory interface.
 */
interface FixedTypeInterface extends FactoryInterface
{
    /**
     * @return string $class
     */
    public function getType();
}
