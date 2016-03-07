<?php
/**
 * @author Deepak Pandey
 */
namespace Adition\AdBundle\Tests\Service;

use Mockery;
use Adition\AdBundle\Entity\User;
use Adition\AdBundle\Entity\Campaign;
use Adition\AdBundle\Service\CampaignService;
use Symfony\Component\HttpKernel\Exception\HttpException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class CampaignServiceTest extends TestCase
{

    public function testGetCampaignThrowsException()
    {
        $campaignService = $this->container->get('adition.campaign_service');
        $user = $this->createFakeUser();
        $this->setExpectedException(NotFoundHttpException::class, 'Campaign Not Found');
        $campaignService->get($user, 1);
    }

    public function testGetCampaignReturnsArray()
    {
        $em = $this->container->get('doctrine.orm.default_entity_manager');
        $repository = $em->getRepository(Campaign::class);
        $campaignRepository = Mockery::mock($repository);
        $campaignService = new CampaignService($campaignRepository);

        $user = $this->createFakeUser();
        $em->persist($user);
        $campaign = $this->createFakeCampaign($user);
        $params = [
            'name' => 'Name',
            'state' => true,
            'startDate' => '2016-02-02',
            'endDate' => '2017-02-30',
            'requestLimit' => 1000
        ];

        $campaignRepository->shouldReceive('findOneBy')->andReturn($campaign);
        $data = $campaignService->create($user, $params);

        $this->assertNotEmpty($data);
        $this->assertArrayHasKey('campaignName', $data);
        $this->assertArrayHasKey('startDate', $data);
        $this->assertArrayHasKey('endDate', $data);
    }

    public function testFormatData()
    {
        $user = $this->createFakeUser();
        $campaign = $this->createFakeCampaign($user);

        $formattedArray = [
            'id' => $campaign->getId(),
            'campaignName' => $campaign->getName(),
            'state' => $campaign->getState(),
            'startDate' => $campaign->getStartDate(),
            'endDate' => $campaign->getEndDate(),
            'requestLimit' => $campaign->getRequestLimit(),
            'requestCount' => $campaign->getRequestCount(),
            'banners' => $campaign->getBanners(),
            'bannerCount' => $campaign->getBannerCount()
        ];

        $campaignService = Mockery::mock(CampaignService::class);
        $result = $campaignService->formatData($campaign);
        $this->assertSame($result, $formattedArray);
    }

    public function testCreateCampaign()
    {
        $em = $this->container->get('doctrine.orm.default_entity_manager');
        $repository = $em->getRepository(Campaign::class);
        $campaignRepository = Mockery::mock($repository);
        $campaignService = new CampaignService($campaignRepository);

        $user = $this->createFakeUser();
        $em->persist($user);
        $params = [
            'name' => 'Name',
            'state' => true,
            'startDate' => '2016-02-02',
            'endDate' => '2017-02-30',
            'requestLimit' => 1000
        ];
        $data = $campaignService->create($user, $params);
        $this->assertNotEmpty($data);
        $this->assertArrayHasKey('campaignName', $data);
        $this->assertArrayHasKey('startDate', $data);
        $this->assertArrayHasKey('endDate', $data);

    }

    public function testCreateCampaignWillThrowException()
    {
        $em = $this->container->get('doctrine.orm.default_entity_manager');
        $repository = $em->getRepository(Campaign::class);
        $campaignRepository = Mockery::mock($repository);
        $campaignService = new CampaignService($campaignRepository);

        $user = $this->createFakeUser();
        $em->persist($user);
        $params = [
            'name' => 'Name',
            'state' => true,
            'startDate' => '2016-02-02',
            'endDate' => '2017-02-30',
            'requestLimit' => 1000
        ];
        $campaignRepository->shouldReceive('create')->andReturn(false);
        $this->setExpectedException(HttpException::class, 'Something went wrong!');
        $campaignService->create($user, $params);

    }

    public function testUpdateCampaignWillThrowException()
    {
        $em = $this->container->get('doctrine.orm.default_entity_manager');
        $repository = $em->getRepository(Campaign::class);
        $campaignRepository = Mockery::mock($repository);
        $campaignService = new CampaignService($campaignRepository);

        $user = $this->createFakeUser();
        $em->persist($user);
        $user = $this->createFakeUser();
        $campaign = $this->createFakeCampaign($user);
        $params = [
            'name' => 'Name',
            'state' => true,
            'startDate' => '2016-02-02',
            'endDate' => '2017-02-30',
            'requestLimit' => 1000
        ];
        $this->setExpectedException(HttpException::class, 'Something went wrong!');
        $data = $campaignService->update($user, $params, $campaign->getId());

        $campaignRepository->shouldReceive('update')->andReturn($campaign);
        $result = $campaignService->update($user, $params, 1);
        $this->assertNotEmpty($result);
    }

    public function testUpdateCampaign()
    {
        $em = $this->container->get('doctrine.orm.default_entity_manager');
        $repository = $em->getRepository(Campaign::class);
        $campaignRepository = Mockery::mock($repository);
        $campaignService = new CampaignService($campaignRepository);

        $user = $this->createFakeUser();
        $em->persist($user);
        $user = $this->createFakeUser();
        $campaign = $this->createFakeCampaign($user);
        $params = [
            'name' => 'Name',
            'state' => true,
            'startDate' => '2016-02-02',
            'endDate' => '2017-02-30',
            'requestLimit' => 1000
        ];

        $campaignRepository->shouldReceive('update')->andReturn($campaign);
        $result = $campaignService->update($user, $params, 1);
        $this->assertNotEmpty($result);
    }

    public function testDeleteCampaign()
    {
        $em = $this->container->get('doctrine.orm.default_entity_manager');
        $repository = $em->getRepository(Campaign::class);
        $campaignRepository = Mockery::mock($repository);
        $campaignService = new CampaignService($campaignRepository);

        $user = $this->createFakeUser();
        $em->persist($user);

        $campaign = $this->createFakeCampaign($user);
        $data = $campaignService->delete($user, $campaign->getId());
    }


    private function createFakeCampaign(User $user)
    {
        $campaign = new Campaign();
        $campaign->getName('Test Campaign');
        $campaign->getState(true);
        $campaign->setStartDate(new \DateTime('2015-01-01'));
        $campaign->setEndDate(new \DateTime('2015-01-05'));
        $campaign->setRequestLimit(100);
        $campaign->setUser($user);

        return $campaign;
    }

    /**
     * @return User
     */
    protected function createFakeUser()
    {
        $user = new User();
        $user->setUsername(uniqid('username', 5))->setPassword('pass');

        return $user;
    }
}
