<?php

namespace Concretehouse\Dp\Factory\Test\Providers;

use Concretehouse\Dp\Factory\Providers\ServiceProvider;
use Phake;

/**
 * Test for factory service provider.
 */
class ServiceProviderTest extends \PHPUnit_Framework_TestCase
{
    /**
     * Set up
     */
    public function setUp()
    {
        $this->container = new \Pimple\Container;
        $this->provider = new ServiceProvider;
    }

    /**
     * @test
     */
    public function registersFunctions()
    {
        $domain = ServiceProvider::DOMAIN;
        $this->provider->register($this->container);
        $this->assertInstanceOf('Concretehouse\Dp\Factory\FunctionsInterface', $this->container["$domain.functions"]);
        $this->assertInstanceOf('Concretehouse\Dp\Factory\Concretes\Functions', $this->container["$domain.functions"]);
    }

    /**
     * @test
     */
    public function registersFactory()
    {
        $domain = ServiceProvider::DOMAIN;
        $this->provider->register($this->container);
        $this->assertInstanceOf('Concretehouse\Dp\Factory\FactoryInterface', $this->container["$domain.factory"]);
        $this->assertInstanceOf('Concretehouse\Dp\Factory\RegisterableInterface', $this->container["$domain.factory"]);
        $this->assertInstanceOf('Concretehouse\Dp\Factory\Concretes\Registerable', $this->container["$domain.factory"]);
    }

    /**
     * @test
     */
    public function canMakeRegisterableFromFactory()
    {
        $domain = ServiceProvider::DOMAIN;
        $this->provider->register($this->container);
        $object = $this->container["$domain.factory"]->make('registerable');

        $this->assertInstanceOf('Concretehouse\Dp\Factory\FactoryInterface', $object);
        $this->assertInstanceOf('Concretehouse\Dp\Factory\RegisterableInterface', $object);
        $this->assertInstanceOf('Concretehouse\Dp\Factory\Concretes\Registerable', $object);
    }

    /**
     * @test
     */
    public function canMakeRegisterableFixedTypeFromFactory()
    {
        $domain = ServiceProvider::DOMAIN;
        $this->provider->register($this->container);
        $object = $this->container["$domain.factory"]->make('registerable_fixed_type', array('Countable'));

        $this->assertInstanceOf('Concretehouse\Dp\Factory\FixedTypeInterface', $object);
        $this->assertInstanceOf('Concretehouse\Dp\Factory\Concretes\RegisterableFixedType', $object);

        $this->assertSame('Countable', $object->getType());
    }

    /**
     * @test
     */
    public function canMakeRegisterableFactoryInjectableFromFactory()
    {
        $domain = ServiceProvider::DOMAIN;
        $this->provider->register($this->container);
        $object = $this->container["$domain.factory"]->make('registerable_factory_injectable');

        $this->assertInstanceOf('Concretehouse\Dp\Factory\FactoryInterface', $object);
        $this->assertInstanceOf('Concretehouse\Dp\Factory\RegisterableInterface', $object);
        $this->assertInstanceOf('Concretehouse\Dp\Factory\FactoryInjectableInterface', $object);
        $this->assertInstanceOf('Concretehouse\Dp\Factory\Concretes\RegisterableFactoryInjectable', $object);
    }
}
