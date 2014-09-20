<?php

namespace Concretehouse\Dp\Factory\Test\Providers;

use Concretehouse\Dp\Factory\Providers\ServiceProvider;
use Phake;

/**
 * Test for factory service provider.
 */
class FactoryInterfaceTest extends \PHPUnit_Framework_TestCase
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
        $dom = ServiceProvider::DOMAIN;
        $this->provider->register($this->container);
        $this->assertInstanceOf('Concretehouse\Dp\Factory\FunctionsInterface', $this->container["$dom.functions"]);
        $this->assertInstanceOf('Concretehouse\Dp\Factory\Concretes\Functions', $this->container["$dom.functions"]);
    }

    /**
     * @test
     */
    public function registersRegisterable()
    {
        $dom = ServiceProvider::DOMAIN;
        $this->provider->register($this->container);
        $this->assertInstanceOf('Concretehouse\Dp\Factory\RegisterableInterface', $this->container["$dom.registerable"]);
        $this->assertInstanceOf('Concretehouse\Dp\Factory\Concretes\Registerable', $this->container["$dom.registerable"]);
    }

    /**
     * @test
     */
    public function registersRegisterableFactoryInjectable()
    {
        $dom = ServiceProvider::DOMAIN;
        $this->provider->register($this->container);
        $this->assertInstanceOf('Concretehouse\Dp\Factory\RegisterableInterface', $this->container["$dom.registerable_factory_injectable"]);
        $this->assertInstanceOf('Concretehouse\Dp\Factory\FactoryInjectableInterface', $this->container["$dom.registerable_factory_injectable"]);
        $this->assertInstanceOf('Concretehouse\Dp\Factory\Concretes\RegisterableFactoryInjectable', $this->container["$dom.registerable_factory_injectable"]);
    }
}
