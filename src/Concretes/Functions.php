<?php

namespace Concretehouse\Dp\Factory\Concretes;

use Concretehouse\Dp\Factory\FunctionsInterface;

/**
 * Functions-class for factory.
 */
class Functions implements FunctionsInterface
{
    /**
     * @param mixed $class
     * @param boolean $autoload
     * @return array|false
     * @link http://php.net/manual/en/function.class-implements.php
     */
    public function classImplements($class, $autoload = true)
    {
        return class_implements($class, $autoload);
    }
}
