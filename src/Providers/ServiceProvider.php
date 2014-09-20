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
        $dom = self::DOMAIN;

        $container["$dom.functions"] = function($c) {
            return new Concretes\Functions;
        };

        $container["$dom.registerable"] = function($c) use ($dom) {
            return new Concretes\Registerable($c["$dom.functions"]);
        };

        $container["$dom.registerable_factory_injectable"] = function($c) use ($dom) {
            return new Concretes\RegisterableFactoryInjectable($c["$dom.functions"]);
        };
    }
}
