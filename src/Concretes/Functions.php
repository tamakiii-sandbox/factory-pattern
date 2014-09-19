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
     * @return array
     * @link http://php.net/manual/en/function.class-implements.php
     */
    public function classImplements($class, $autoload = true)
    {
        return class_implements($class, $autoload);
    }

    /**
     * @param string $class
     * @param array $args
     * @return mixed
     */
    public function newInstanceArgs($class, array $args = array())
    {
        // Prepare relrection class
        $reflect = new \ReflectionClass($class);

        // Create with `new` if class does not have constructor
        // This can be written like this(PHP >= 5.4.0)
        //   return $reflect->newInstanceWithoutConstructor();
        if (!$ctor = $reflect->getConstructor()) {
            return new $class;
        }

        // Create instance with constructor
        return $reflect->newInstanceArgs($args);
    }
}
