<?php

namespace Adition\AdBundle\Tests;

use Adition\AdBundle\Entity\User;
use Adition\AdBundle\Entity\ContentUnit;
use Adition\AdBundle\Tests\AbstractTestCase as TestCase;

class ContentUnitTest extends TestCase
{

    /**
     * @var ContentUnit
     */
    protected $object;

    public function setUp()
    {
        $this->object = new ContentUnit();
    }

    public function testGetId()
    {
        $this->assertNull($this->object->getId());
    }

    public function testGetWidth()
    {
        $this->assertNull($this->object->getWidth());
    }

    public function testGetHeight()
    {
        $this->assertNull($this->object->getHeight());
    }

    public function testGetUser()
    {
        $this->assertNull($this->object->getUser());
    }

    public function testSetWidth()
    {
        $width = 100;
        $this->object->setWidth($width);
        $this->assertSame($width, $this->object->getWidth());
    }

    public function testSetHeight()
    {
        $height = 300;
        $this->object->setHeight($height);
        $this->assertSame($height, $this->object->getHeight());
    }

    public function testSetUser()
    {
        $user = new User();
        $this->object->setUser($user);
        $this->assertSame($user, $this->object->getUser());
    }
}
