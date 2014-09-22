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

        $container["$domain._factory"] = function($c) use ($domain) {
            return new Concretes\Registerable($c["$domain.functions"]);
        };

        $container["$domain.factory"] = function($c) use ($domain) {
            $functions = $c["$domain.functions"];
            $factory = $c["$domain._factory"];

            $factory->registers(array(
                'registerable' => array(
                    'Concretehouse\Dp\Factory\Concretes\Registerable',
                    array($functions)
                ),
                'registerable_fixed_type' => array(
                    'Concretehouse\Dp\Factory\Concretes\RegisterableFixedType',
                    array(null, $functions)
                ),
                'registerable_factory_injectable' => array(
                    'Concretehouse\Dp\Factory\Concretes\RegisterableFactoryInjectable',
                    array($functions)
                ),
            ));

            return $factory;
        };
    }
}
