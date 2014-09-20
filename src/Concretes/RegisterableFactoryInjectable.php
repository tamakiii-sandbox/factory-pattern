<?php

namespace Concretehouse\Dp\Factory\Concretes;

use Concretehouse\Dp\Factory\FactoryInterface;
use Concretehouse\Dp\Factory\FunctionsInterface;
use Concretehouse\Dp\Factory\MatchableInterface;
use Concretehouse\Dp\Factory\FactoryInjectableInterface;

/**
 * Matcher-injectable registerable factory class.
 */
class RegisterableFactoryInjectable
    extends Registerable
    implements FactoryInjectableInterface
{
    /**
     * @var array
     */
    private $factories;


    /**
     * @param FunctionsInterface $functions
     */
    public function __construct(FunctionsInterface $functions)
    {
        parent::__construct($functions);

        $this->factories = array();
    }

    /**
     * @param MatchableInterface $factory
     */
    public function addFactory(MatchableInterface $factory)
    {
        if (!$factory instanceof FactoryInterface) {
            throw new \InvalidArgumentException('Factory must implement FactoryInterface.');
        }

        $this->factories[] = $factory;
    }

    /**
     * @param string $name
     * @param array $args
     * @return mixed
     */
    public function make($name, array $args = array())
    {
        $class = $this->getClass($name);
        $factory = $this->match($class);
        return $factory->make($class, $args);
    }

    /**
     * @param string $class
     * @return MatchableInterface
     */
    protected function match($class)
    {
        if (!$interfaces = $this->getFunctions()->classImplements($class)) {
            throw new \UnexpectedValueException("Factory must implement least one interface '{$class}'");
        }

        foreach ($interfaces as $interface) {
            foreach ($this->factories as $factory) {
                if ($factory->match($interface)) {
                    return $factory;
                }
            }
        }

        throw new \LogicException("No matcher found for '{$class}'");
    }
}
