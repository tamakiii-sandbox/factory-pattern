<?php

namespace Concretehouse\Dp\Factory;

/**
 * Factory interface for fixed class(doesn't need to specify name).
 */
interface FixedFactoryInterface
{
    /**
     * @param mixed
     * @return object
     */
    public function make();
}
