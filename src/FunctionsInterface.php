<?php

namespace Concretehouse\Dp\Factory;

/**
 * Functions-interface for factory.
 */
interface FunctionsInterface
{
    /**
     * @param mixed $class
     * @param boolean $autoload
     * @return array|false
     * @link http://php.net/manual/en/function.class-implements.php
     */
    public function classImplements($class, $autoload = true);
}
