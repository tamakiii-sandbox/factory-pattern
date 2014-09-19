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
     * @return array
     * @link http://php.net/manual/en/function.class-implements.php
     */
    public function classImplements($class, $autoload = true);

    /**
     * @param string $class
     * @param array $args
     * @return mixed
     */
    public function newInstanceArgs($class, array $args = array());
}
