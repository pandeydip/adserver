<?php

namespace Adition\ApiBundle\Tests\DependencyInjection;


use PHPUnit_Framework_TestCase;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Adition\ApiBundle\DependencyInjection\AditionApiExtension;

class AditionApiExtensionTest extends PHPUnit_Framework_TestCase
{

    /**
     * @var AditionApiExtension
     */
    protected $extension;

    /**
     * Root name of configuration
     *
     * @var string
     */
    private $root;

    public function setUp()
    {
        parent::setUp();
        $this->extension = $this->getExtension();
        $this->root = 'adition_api';
    }

    public function testGetConfigWithDefaultValues()
    {
        $this->extension->load([], $container = $this->getContainer());
        $this->assertFalse($container->has('test-service'));
    }

    /**
     * @return AditionApiExtension
     */
    protected function getExtension()
    {
        return new AditionApiExtension();
    }

    /**
     * @return ContainerBuilder
     */
    private function getContainer()
    {
        $container = new ContainerBuilder();

        return $container;
    }
}
