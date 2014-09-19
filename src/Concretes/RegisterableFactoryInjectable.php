<?php

namespace Concretehouse\Dp\Factory\Concretes;

use Concretehouse\Dp\Factory\FunctionsInterface;
use Concretehouse\Dp\Factory\MatchableInterface;
use Concretehouse\Dp\Factory\MatcherInjectableInterface;

/**
 * Matcher-injectable registerable factory class.
 */
class RegisterableFactoryInjectable
    extends Registerable
    implements MatcherInjectableInterface
{
    /**
     * @var array
     */
    private $factories;

    /**
     * @var FunctionsInterface
     */
    private $functions;


    /**
     * @param FunctionsInterface $functions
     * @param array $list
     */
    public function __construct(FunctionsInterface $functions, array $list = array())
    {
        $this->factories = array();
        $this->functions = $functions;

        parent::__construct($list);
    }

    /**
     * @param MatchableInterface $factory
     */
    public function addFactory(MatchableInterface $factory)
    {
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
        return $factory->makeByClass($class, $args);
    }

    /**
     * @param string $class
     * @return MatchableInterface
     */
    protected function match($class)
    {
        if (!$interfaces = $this->functions->classImplements($class)) {
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
