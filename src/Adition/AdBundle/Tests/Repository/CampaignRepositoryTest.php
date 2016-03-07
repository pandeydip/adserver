<?php
/**
 * @author Deepak Pandey
 */
namespace Adition\AdBundle\Tests\Repository;

use DateTime;
use Adition\AdBundle\Entity\Banner;
use Adition\AdBundle\Entity\Campaign;

class CampaignRepositoryTest extends RepositoryTestCase
{

    public function testCreateCampaign()
    {
        /** @var Campaign $campaign */
        $campaign = $this->createCampaign();

        $campaignData = $this->em->getRepository(Campaign::class)->find($campaign->getId());
        $this->assertEquals('name', $campaignData->getName());
    }

    public function testAddBannerToCampaignTest()
    {
        /** @var Banner $banner */
        $banner = $this->createBanner();
        /** @var Campaign $campaign */
        $campaign = $this->createCampaign();

        $campaign->addBanner($banner);
        $campaign->setBannerCount($campaign->getBannerCount() + 1);
        $this->em->persist($campaign);
        $this->em->flush();

        $campaignData = $this->em->getRepository(Campaign::class)->find($campaign->getId());
        $bannerData = $this->em->getRepository(Banner::class)->find($banner->getId());

        $this->assertEquals(1, $campaignData->getBannerCount());
        $this->assertEquals($campaign, $bannerData->getCampaign());
    }

    /**
     * @return Campaign
     */
    protected function createCampaign()
    {
        $campaign = new Campaign();
        $campaign->setName('name');
        $campaign->setRequestLimit(1000);
        $campaign->setStartDate(new DateTime('2012-01-05'));
        $campaign->setEndDate(new DateTime('2015-01-05'));
        $campaign->setState(true);
        $this->em->persist($campaign);
        $this->em->flush();

        return $campaign;
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
        return ['banner', 'campaign'];
    }
}
