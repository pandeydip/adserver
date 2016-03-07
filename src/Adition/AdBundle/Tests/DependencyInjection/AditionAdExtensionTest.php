<?php

namespace Adition\AdBundle\Tests;


use PHPUnit_Framework_TestCase;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Adition\AdBundle\DependencyInjection\AditionAdExtension;

class AditionAdExtensionTest extends PHPUnit_Framework_TestCase
{

    /**
     * @var AditionAdExtension
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
        $this->root = 'adition_ad';
    }

    public function testGetConfigWithDefaultValues()
    {
        $this->extension->load([], $container = $this->getContainer());
        $this->assertTrue($container->has('adition.user_repository'));
        $this->assertTrue($container->has('adition.campaign_repository'));
        $this->assertTrue($container->has('adition.content_unit_repository'));
        $this->assertTrue($container->has('adition.content_banner_repository'));
        $this->assertTrue($container->has('adition.banner_service'));
        $this->assertTrue($container->has('adition.content_unit'));
        $this->assertTrue($container->has('adition.campaign_service'));
        $this->assertTrue($container->has('adition.user_manager'));
    }

    /**
     * @return AditionAdExtension
     */
    protected function getExtension()
    {
        return new AditionAdExtension();
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
