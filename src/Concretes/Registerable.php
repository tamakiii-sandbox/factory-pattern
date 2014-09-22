<?php

namespace Concretehouse\Dp\Factory\Concretes;

use Concretehouse\Dp\Factory\FunctionsInterface;
use Concretehouse\Dp\Factory\RegisterableInterface;

/**
 * Registerable factory.
 */
class Registerable
    extends Factory
    implements RegisterableInterface
{
    /**
     * @var array
     */
    private $list;


    /**
     * @param FunctionsInterface $functions
     */
    public function __construct(FunctionsInterface $functions)
    {
        parent::__construct($functions);
        $this->list = array();
    }

    /**
     * @param string $name
     * @parma array $args
     * @return object
     */
    public function make($name, array $args = array())
    {
        // Prepare params
        $class = $this->getClass($name);
        $args = array_replace($this->getArgs($name), $args);

        return parent::make($class, $args);
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
        return $this->list[$name]['class'];
    }

    /**
     * @param string $name
     * @return array
     */
    protected function getArgs($name)
    {
        if (empty($this->list[$name])) {
            throw new \LogicException("No args found for '{$name}'");
        }
        return $this->list[$name]['args'];
    }

    /**
     * @param string $name
     * @param string $class
     * @param array $args
     */
    public function register($name, $class, array $args = array())
    {
        $this->list[$name] = array('class' => $class, 'args' => $args);
    }

    /**
     * @param array $list
     */
    public function registers(array $list)
    {
        foreach ($list as $name => $array) {
            list($class, $args) = $this->arrayToRow(
                is_array($array) ? $array : array($array)
            );
            $this->register($name, $class, $args);
        }
    }

    /**
     * @param array $array
     * @return array
     */
    private function arrayToRow(array $array)
    {
        if (empty($array[0])) {
            throw new \InvalidArgumentException('Row of registers() must have least one values.');
        }
        if (isset($array[1]) && !is_array($array[1])) {
            throw new \InvalidArgumentException('Args must be an array.');
        }

        return array($array[0], isset($array[1]) ? $array[1] : array());
    }
}
