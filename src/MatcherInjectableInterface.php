<?php

namespace Concretehouse\Dp\Factory;

/**
 * Matcher injectable interface.
 */
interface MatcherInjectableInterface extends FactoryInterface
{
    /**
     * @param string $name
     * @param array $args
     * @return mixed
     */
    public function addFactory(MatchableInterface $factory);
}
