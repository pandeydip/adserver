<?php

namespace Adition\AdBundle\Tests;

use Adition\AdBundle\Entity\User;
use Adition\AdBundle\Entity\Banner;
use Adition\AdBundle\Entity\Campaign;
use Adition\AdBundle\Tests\AbstractTestCase as TestCase;

class BannerTest extends TestCase
{

    /**
     * @var Banner
     */
    protected $object;

    protected function setUp()
    {
        $this->object = new Banner();
    }

    public function testGetId()
    {
        $this->assertNull($this->object->getId());
    }

    public function testGetName()
    {
        $this->assertNull($this->object->getName());
    }

    public function testGetExtension()
    {
        $this->assertNull($this->object->getExtension());
    }

    public function testGetCaption()
    {
        $this->assertNull($this->object->getCaption());
    }

    public function testGetHeight()
    {
        $this->assertNull($this->object->getHeight());
    }

    public function testGetWidth()
    {
        $this->assertNull($this->object->getWidth());
    }

    public function testGetUrl()
    {
        $this->assertNull($this->object->getUrl());
    }

    public function testGetUser()
    {
        $this->assertNull($this->object->getUser());
    }

    public function testGetCampaign()
    {
        $this->assertNull($this->object->getCampaign());
    }

    public function testSetName()
    {
        $name = 'Adition Ad';
        $this->object->setName($name);
        $this->assertEquals($name, $this->object->getName());
    }

    public function testSetExtension()
    {
        $extension = 'jpeg';
        $this->object->setExtension($extension);
        $this->assertEquals($extension, $this->object->getExtension());
    }

    public function testSetCaption()
    {
        $caption = 'Adition Test Advertisment';
        $this->object->setCaption($caption);
        $this->assertEquals($caption, $this->object->getCaption());
    }

    public function testSetUrl()
    {
        $url = 'http://adition.com';
        $this->object->setUrl($url);
        $this->assertEquals($url, $this->object->getUrl());
    }

    public function testSetHeight()
    {
        $height = 100;
        $this->object->setHeight($height);
        $this->assertSame($height, $this->object->getHeight());
    }

    public function testSetWidth()
    {
        $width = 200;
        $this->object->setWidth($width);
        $this->assertSame($width, $this->object->getWidth());
    }

    public function testSetUser()
    {
        $user = new User();
        $this->object->setUser($user);
        $this->assertSame($user, $this->object->getUser());
    }

    public function testSetCampaign()
    {
        $campaign = new Campaign();
        $this->object->setCampaign($campaign);
        $this->assertSame($campaign, $this->object->getCampaign());
    }
}
