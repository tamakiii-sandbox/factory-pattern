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
    public function registersRegisterable()
    {
        $domain = ServiceProvider::DOMAIN;
        $this->provider->register($this->container);
        $this->assertInstanceOf('Concretehouse\Dp\Factory\RegisterableInterface', $this->container["$domain.registerable"]);
        $this->assertInstanceOf('Concretehouse\Dp\Factory\Concretes\Registerable', $this->container["$domain.registerable"]);
    }

    /**
     * @test
     */
    public function registersRegisterableFactoryInjectable()
    {
        $domain = ServiceProvider::DOMAIN;
        $this->provider->register($this->container);
        $this->assertInstanceOf('Concretehouse\Dp\Factory\RegisterableInterface', $this->container["$domain.registerable_factory_injectable"]);
        $this->assertInstanceOf('Concretehouse\Dp\Factory\FactoryInjectableInterface', $this->container["$domain.registerable_factory_injectable"]);
        $this->assertInstanceOf('Concretehouse\Dp\Factory\Concretes\RegisterableFactoryInjectable', $this->container["$domain.registerable_factory_injectable"]);
    }
}
