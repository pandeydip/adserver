<?php

namespace Adition\AdBundle\Tests\Service;

use ReflectionClass;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;
use Symfony\Component\DependencyInjection\ContainerInterface;

class TestCase extends KernelTestCase
{

    /**
     * @var ContainerInterface
     */
    protected $container;

    /**
     * Pre setup for repository test
     */
    public function setUp()
    {
        parent::setUp();
        $kernel = static::createKernel();
        $kernel->boot();
        $this->container = $kernel->getContainer();
    }

    /**
     * Execute after test is complete
     */
    public function tearDown()
    {
        parent::tearDown();
    }

    /**
     * Invokes a method of an object instance passed regardless of its visibility (public, protected, private)
     *
     * @param mixed $instance The object instance whose method is to be invoked
     * @param string $method  The method name
     * @param array $args     Arguments as an array (optional)
     * @return mixed Returns the return value of the method call
     */
    public function invokeMethod($instance, $method, array $args = [])
    {
        $class = new ReflectionClass($instance);
        $method = $class->getMethod($method);
        $method->setAccessible(true);

        return $method->invokeArgs($instance, $args);
    }


}
