<?php
/**
 * @author Deepak Pandey
 */
namespace Adition\AdBundle\Tests\Repository;

use Adition\AdBundle\Entity\Banner;

class BannerRepositoryTest extends RepositoryTestCase
{

    public function testCreateBanner()
    {
        $banner = $this->createBanner();

        $bannerData = $this->em->getRepository(Banner::class)->find($banner->getId());
        $this->assertEquals(100, $bannerData->getHeight());
        $this->assertEquals(100, $bannerData->getWidth());
        $this->assertEquals('This is caption', $bannerData->getCaption());
        $this->assertEquals('.jpg', $bannerData->getExtension());
        $this->assertEquals('http://test.com', $bannerData->getUrl());
        $this->assertEquals($banner->getId(), $bannerData->getId());
    }

    /**
     * @return Banner
     */
    protected function createBanner()
    {
        $banner = new Banner();
        $banner->setHeight(100);
        $banner->setWidth(100);
        $banner->setCaption('This is caption');
        $banner->setName('Test Banner');
        $banner->setExtension('.jpg');
        $banner->setUrl('http://test.com');
        $this->em->persist($banner);
        $this->em->flush();

        return $banner;
    }

    protected function getTables()
    {
        return ['banner'];
    }
}
