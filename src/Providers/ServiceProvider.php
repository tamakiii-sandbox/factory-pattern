<?php

namespace Concretehouse\Dp\Factory\Providers;

use Concretehouse\Dp\Factory\Concretes;

/**
 * Provides factory service.
 */
class ServiceProvider implements \Pimple\ServiceProviderInterface
{
    const DOMAIN = 'concretehouse.dp.factory';

    /**
     * @param \Pimple\Container $container
     */
    public function register(\Pimple\Container $container)
    {
        $domain = self::DOMAIN;

        $container["$domain.functions"] = function($c) {
            return new Concretes\Functions;
        };

        $container["$domain.registerable"] = function($c) use ($domain) {
            return new Concretes\Registerable($c["$domain.functions"]);
        };

        $container["$domain.registerable_factory_injectable"] = function($c) use ($domain) {
            return new Concretes\RegisterableFactoryInjectable($c["$domain.functions"]);
        };
    }
}
