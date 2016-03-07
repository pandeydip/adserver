<?php

namespace Adition\AdBundle\Service;

use FOS\RestBundle\Util\Codes;
use Adition\AdBundle\Entity\User;
use Adition\AdBundle\Entity\ContentUnit;
use Adition\AdBundle\Repository\ContentUnitRepository;
use Symfony\Component\HttpKernel\Exception\HttpException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class ContentUnitService
{

    /**
     * @var ContentUnitRepository
     */
    private $contentUnitRepository;


    /**
     * ContentUnit constructor.
     *
     * @param ContentUnitRepository $contentUnitRepository
     */
    public function __construct(ContentUnitRepository $contentUnitRepository)
    {
        $this->contentUnitRepository = $contentUnitRepository;
    }

    /**
     * @param $data
     * @param User $user
     * @return ContentUnit
     */
    public function create($data, User $user)
    {
        if ($this->contentUnitRepository->alreadyExists($data, $user)) {
            throw new HttpException(Codes::HTTP_CONFLICT, 'Content unit already created.');
        }

        return $this->contentUnitRepository->create($data, $user);

    }

    /**
     * @param $id
     * @param User $user
     * @return array
     * @throws NotFoundHttpException
     */
    public function get($id, User $user)
    {
        $contentUnit = $this->contentUnitRepository->findOneBy([
            'id' => $id,
            'user' => $user
        ]);

        if (!$contentUnit) {
            throw  new NotFoundHttpException('Content Unit not found');
        }

        return [
            'message' => [
                'id' => $contentUnit->getId(),
                'height' => $contentUnit->getHeight(),
                'width' => $contentUnit->getWidth()
            ],
            'statusCode' => Codes::HTTP_OK
        ];
    }

    /**
     * @param $id
     * @param User $user
     * @return bool
     */
    public function delete($id, User $user)
    {
        $deleted = $this->contentUnitRepository->delete($id, $user);

        if (!$deleted) {
            throw new HttpException(Codes::HTTP_UNPROCESSABLE_ENTITY, 'Couldn\'t delete the entity');
        }

        return ['message' => 'Content unit deleted successfully.', 'statusCode' => Codes::HTTP_OK];
    }
}
