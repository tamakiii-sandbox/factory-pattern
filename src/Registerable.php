<?php

namespace Concretehouse\Dp\Factory;

/**
 * Registerable factory.
 */
class Registerable implements RegisterableInterface
{
    /**
     * @var array
     */
    private $list;


    /**
     * @param array $list
     */
    public function __construct(array $list = array())
    {
        $this->list = $list;
    }

    /**
     * @param string $name
     * @parma array $args
     * @return mixed
     */
    public function make($name, array $args = array())
    {
        if (empty($this->list[$name])) {
            throw new \LogicException("No class found for '{$name}'");
        }

        // Prepare relrection class
        $class = $this->list[$name];
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

    /**
     * @param string $name
     * @param string $class
     */
    public function register($name, $class)
    {
        $this->list[$name] = $class;
    }
}
