<?php

namespace Concretehouse\Dp\Factory\Concretes;

use Concretehouse\Dp\Factory\FunctionsInterface;
use Concretehouse\Dp\Factory\RegisterableInterface;

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
     * @var FunctionsInterface
     */
    private $functions;


    /**
     * Constructor
     */
    public function __construct(FunctionsInterface $functions)
    {
        $this->list = array();
        $this->functions = $functions;
    }

    /**
     * @param string $name
     * @parma array $args
     * @return object
     */
    public function make($name, array $args = array())
    {
        $class = $this->getClass($name);
        $object = $this->getFunctions()->newInstanceArgs($class, $args);

        if (empty($object) || !is_object($object)) {
            throw new \UnexpectedValueException("Failed to create new instance with {$name}({$class})");
        }

        return $object;
    }

    /**
     * @param string $name
     * @return string
     */
    protected function getClass($name)
    {
        if (empty($this->list[$name])) {
            throw new \LogicException("No class found for '{$name}'");
        }
        return $this->list[$name];
    }

    /**
     * @param string $name
     * @param string $class
     */
    public function register($name, $class)
    {
        $this->list[$name] = $class;
    }

    /**
     * @param array $list
     */
    public function registers(array $list)
    {
        foreach ($list as $name => $class) {
            $this->register($name, $class);
        }
    }

    /**
     * @return FunctionsInterface
     */
    protected function getFunctions()
    {
        return $this->functions;
    }
}
