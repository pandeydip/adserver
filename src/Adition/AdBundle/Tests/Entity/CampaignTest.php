<?php

namespace Adition\AdBundle\Tests;

use DateTime;
use Adition\AdBundle\Entity\User;
use Adition\AdBundle\Entity\Banner;
use Adition\AdBundle\Entity\Campaign;
use Adition\AdBundle\Tests\AbstractTestCase as TestCase;

class CampaignTest extends TestCase
{

    /**
     * @var Campaign
     */
    protected $object;

    public function setUp()
    {
        $this->object = new Campaign();
    }

    public function testGetId()
    {
        $this->assertNull($this->object->getId());
    }

    public function testGetName()
    {
        $this->assertNull($this->object->getName());
    }

    public function testGetState()
    {
        $this->assertSame((int)1, $this->object->getState());
    }

    public function testGetStartDate()
    {
        $this->assertNull($this->object->getStartDate());
    }

    public function testGetEndDate()
    {
        $this->assertNull($this->object->getEndDate());
    }

    public function testGetRequestLimit()
    {
        $this->assertEquals(0, $this->object->getRequestLimit());
    }

    public function testGetBannerCount()
    {
        $this->assertEquals(0, $this->object->getBannerCount());
    }

    public function testGetBanners()
    {
        $this->assertEmpty($this->object->getBanners());
    }

    public function testGetUser()
    {
        $this->assertNull($this->object->getUser());
    }

    public function testSetName()
    {
        $name = 'Adition Campaign';
        $this->object->setName($name);
        $this->assertEquals($name, $this->object->getName());
    }

    public function testSetState()
    {
        $state = (int)0;
        $this->assertEquals(1, $this->object->getState());
        $this->object->setState($state);
        $this->assertSame($state, $this->object->getState());
    }

    public function testSetStartDate()
    {
        $startDate = new DateTime('now');
        $this->object->setStartDate($startDate);
        $this->assertEquals($startDate, $this->object->getStartDate());
    }

    public function testSetEndDate()
    {
        $endDate = new DateTime('now');
        $this->object->setEndDate($endDate);
        $this->assertEquals($endDate, $this->object->getEndDate());
    }

    public function testSetRequestLimit()
    {
        $requestLimit = 1000;
        $this->object->setRequestLimit($requestLimit);
        $this->assertEquals($requestLimit, $this->object->getRequestLimit());
    }

    public function testIncrementRequestCount()
    {
        $requestCount = 0;
        $this->object->incrementRequestCount($requestCount);
        $this->assertEquals(1, $this->object->getRequestCount());
    }

    public function testSetBannerCount()
    {
        $bannerCount = 0;
        $this->object->setBannerCount($bannerCount);
        $this->assertEquals($bannerCount, $this->object->getBannerCount());
    }

    public function testAddBanenr()
    {
        $banner = new Banner();
        $this->object->addBanner($banner);
        $this->assertEquals($banner, $this->object->getBanners()[0]);
    }

    public function testSetUser()
    {
        $user = new User();
        $this->object->setUser($user);
        $this->assertEquals($user, $this->object->getUser());
    }
}
