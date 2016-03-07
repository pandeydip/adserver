<?php

namespace Adition\ApiBundle\Tests\DependencyInjection;

use PHPUnit_Framework_TestCase;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Adition\CoreBundle\DependencyInjection\AditionCoreExtension;

class AditionCoreExtensionTest extends PHPUnit_Framework_TestCase
{

    /**
     * @var AditionCoreExtension
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
        $this->root = 'adition_core';
    }

    public function testGetConfigWithDefaultValues()
    {
        $this->extension->load([], $container = $this->getContainer());
        $this->assertFalse($container->has('test-service'));
    }

    /**
     * @return AditionCoreExtension
     */
    protected function getExtension()
    {
        return new AditionCoreExtension();
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
