<?php

namespace Adition\AdBundle\Service;

use FOS\RestBundle\Util\Codes;
use Adition\AdBundle\Entity\User;
use Adition\AdBundle\Entity\Campaign;
use Adition\AdBundle\Repository\CampaignRepository;
use Symfony\Component\HttpKernel\Exception\HttpException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class CampaignService
{

    /**
     * @var CampaignRepository
     */
    private $campaignRepository;

    /**
     * CampaignService constructor.
     *
     * @param CampaignRepository $campaignRepository
     */
    public function __construct(CampaignRepository $campaignRepository)
    {
        $this->campaignRepository = $campaignRepository;
    }

    /**
     * @param User $user
     * @param $campaignId
     * @return array
     */
    public function get(User $user, $campaignId)
    {
        /** @var Campaign $campaign */
        $campaign = $this->campaignRepository->findOneBy(['user' => $user, 'id' => $campaignId]);

        if (!$campaign) {
            // TODO: Translation
            throw new NotFoundHttpException('Campaign Not Found');
        }

        return $this->formatData($campaign);
    }

    /**
     * @param User $user
     * @param $params
     * @return array
     */
    public function create(User $user, $params)
    {
        // TODO: Validation
        $campaign = $this->campaignRepository->create($user, $params);

        if (!$campaign) {
            throw new HttpException(Codes::HTTP_INTERNAL_SERVER_ERROR, 'Something went wrong!');
        }

        return $this->formatData($campaign);
    }

    /**
     * @param User $user
     * @param $data
     * @param $campaignId
     * @return array
     */
    public function update(User $user, $data, $campaignId)
    {
        // TODO: Validation
        $campaign = $this->campaignRepository->update(
            $user, $data, $campaignId
        );

        if (!$campaign) {
            throw  new HttpException(500, 'Something went wrong!');
        }

        return $this->formatData($campaign);
    }


    /**
     * @param User $user
     * @param $id
     */
    public function delete(User $user, $id)
    {
        $this->campaignRepository->delete($user, $id);
    }

    /**
     * @param Campaign $campaign
     * @return array
     */
    protected function formatData(Campaign $campaign)
    {
        return [
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
    }
}
