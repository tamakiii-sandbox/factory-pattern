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

        $reflect  = new \ReflectionClass($this->list[$name]);
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
