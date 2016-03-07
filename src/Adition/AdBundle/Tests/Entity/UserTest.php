<?php

namespace Adition\AdBundle\Tests;

use Adition\AdBundle\Entity\User;
use Adition\AdBundle\Entity\Banner;
use Adition\AdBundle\Entity\Campaign;
use Adition\AdBundle\Entity\ContentUnit;
use Adition\AdBundle\Tests\AbstractTestCase as TestCase;

class UserTest extends TestCase
{

    /**
     * @var User
     */
    protected $object;

    protected function setUp()
    {
        $this->object = new User();
    }

    public function testGetId()
    {
        $this->assertNull($this->object->getId());
    }


    public function testGetUsername()
    {
        $this->assertNull($this->object->getUsername());
    }

    public function testGetPassword()
    {
        $this->assertNull($this->object->getPassword());
    }

    public function testSetUsername()
    {
        $username = 'adition';
        $this->object->setUsername($username);
        $this->assertSame($username, $this->object->getUsername());
    }

    public function testSetPassword()
    {
        $password = 'password';
        $this->object->setPassword($password);
        $this->assertSame(md5($password), $this->object->getPassword());
    }

    public function testGetBanners()
    {
        $this->assertEmpty($this->object->getBanners());
    }

    public function testGetCampaigns()
    {
        $this->assertEmpty($this->object->getCampaigns());
    }

    public function testGetContentUnits()
    {
        $this->assertEmpty($this->object->getContentUnits());
    }

    public function testAddBanner()
    {
        $banner = new Banner();
        $this->object->addBanner($banner);
        $this->assertNotEmpty($this->object->getBanners());
        $this->assertSame($banner, $this->object->getBanners()[0]);
    }

    public function testAddCampaigns()
    {
        $campaign = new Campaign();
        $this->object->addCampaign($campaign);
        $this->assertNotEmpty($this->object->getCampaigns());
        $this->assertSame($campaign, $this->object->getCampaigns()[0]);
    }

    public function testAddContentUnit()
    {
        $contentUnit = new ContentUnit();
        $this->object->addContentUnit($contentUnit);
        $this->assertNotEmpty($this->object->getContentUnits());
        $this->assertSame($contentUnit, $this->object->getContentUnits()[0]);
    }
}
