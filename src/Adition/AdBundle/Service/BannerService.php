<?php

namespace Adition\AdBundle\Service;

use Adition\AdBundle\Entity\User;
use Adition\AdBundle\Entity\Banner;
use Adition\AdBundle\Entity\Campaign;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\File\File;
use Adition\AdBundle\Repository\BannerRepository;
use Adition\AdBundle\Repository\CampaignRepository;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;

class BannerService
{

    /**
     * @var BannerRepository
     */
    private $bannerRepository;

    /**
     * @var ContainerInterface
     */
    private $container;

    /**
     * @var CampaignRepository
     */
    private $campaignRepository;

    /**
     * BannerService constructor.
     *
     * @param ContainerInterface $container
     * @param CampaignRepository $campaignRepository
     * @param BannerRepository $bannerRepository
     */
    public function __construct(
        ContainerInterface $container,
        BannerRepository $bannerRepository,
        CampaignRepository $campaignRepository
    ) {

        $this->container = $container;
        $this->bannerRepository = $bannerRepository;
        $this->campaignRepository = $campaignRepository;
    }

    /**
     * Creates a Banner
     *
     * @param Request $request
     * @param User $user
     * @throws BadRequestHttpException
     * @return array
     */
    public function create(Request $request, User $user)
    {
        $bannerImage = $request->files->all();

        if (!array_key_exists('bannerImage', $bannerImage)) {
            throw new BadRequestHttpException('Please upload image file');
        }

        $banner = $bannerImage['bannerImage'];
        if (!$fileData = $this->handleFileUpload($banner)) {
            throw new BadRequestHttpException('Only files with extension jpeg, png, jpg and gif are allowed . ');
        }

        $this->bannerRepository->create($user, array_merge($fileData, $request->request->all()));

        // TODO: Translation
        return [
            'message' => 'Banner created successfully . '
        ];
    }

    /**
     * @param UploadedFile $banner
     * @return array
     */
    protected function handleFileUpload(UploadedFile $banner)
    {

        $allowedExtension = ['jpeg', 'png', 'jpg', 'gif'];
        $extension = $banner->guessExtension();

        if (in_array($extension, $allowedExtension)) {
            $fileName = $this->renameFile($banner);

            $file = $banner->move($this->getUploadRootDir(), $fileName);

            if ($file instanceof File) {
                return [
                    'extension' => $extension,
                    'name' => $fileName
                ];
            }
        }

        return false;
    }

    /**
     * @return string
     */
    protected function getUploadRootDir()
    {
        $uploadPath = $this->container->get('kernel')->getRootDir() . ' /../web / uploads';

        return $uploadPath;
    }

    /**
     * @param UploadedFile $banner
     * @return string
     */
    protected function renameFile(UploadedFile $banner)
    {
        $fileName = time() . $banner->getClientOriginalName();

        return $fileName;
    }

    /**
     * @param Request $request
     * @param User $user
     * @return array
     */
    public function addBannerToCampaign(Request $request, User $user)
    {
        $bannerId = $request->get('bannerId');
        $campaignId = $request->get('campaignId');
        if ($data = $this->checkPermission($bannerId, $campaignId, $user)) {
            $this->campaignRepository->addBannerToCampaign($data);

            return [
                'message' => 'Banner added to campaign successfully'
            ];
        }

        return [
            'message' => 'You don\'t have permission to manage this banner'
        ];
    }

    /**
     * @param $bannerId
     * @param $campaignId
     * @param User $user
     * @return bool
     */
    private function checkPermission(
        $bannerId,
        $campaignId,
        User $user
    ) {
        /** @var Banner $banner */
        $banner = $this->bannerRepository->find($bannerId);
        /** @var Campaign $campaign */
        $campaign = $this->campaignRepository->find($campaignId);

        if ($banner && $campaign && $user == $banner->getUser() && $user == $campaign->getUser()) {
            return [
                'banner' => $banner,
                'campaign' => $campaign
            ];
        }

        return false;
    }

}
