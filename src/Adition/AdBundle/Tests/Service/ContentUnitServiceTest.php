<?php
/**
 * @author Deepak Pandey
 */

namespace Adition\AdBundle\Tests\Service;

use Mockery;
use FOS\RestBundle\Util\Codes;
use Adition\AdBundle\Entity\User;
use Adition\AdBundle\Entity\ContentUnit;
use Adition\AdBundle\Service\ContentUnitService;
use Symfony\Component\HttpKernel\Exception\HttpException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class ContentUnitServiceTest extends TestCase
{

    public function testGetContentUnitReturnsNotFoundException()
    {
        $contentUnit = $this->container->get('adition.content_unit');
        $user = $this->createFakeUser();
        $this->setExpectedException(NotFoundHttpException::class, 'Content Unit not found');
        $contentUnit->get(1, $user);
    }

    public function testGetContentUnitReturnsArray()
    {
        $user = $this->createFakeUser();
        $contentUnit = $this->createContentUnit($user);

        $em = $this->container->get('doctrine.orm.default_entity_manager');
        $repository = $em->getRepository(ContentUnit::class);
        $contentUnitRepository = Mockery::mock($repository);
        $contentUnitService = new ContentUnitService($contentUnitRepository);

        $contentUnitRepository->shouldReceive('findOneBy')->andReturn($contentUnit);
        $result = $contentUnitService->get($contentUnit->getId(), $user);
        $data = [
            'message' => [
                'id' => $contentUnit->getId(),
                'height' => $contentUnit->getHeight(),
                'width' => $contentUnit->getWidth()
            ],
            'statusCode' => Codes::HTTP_OK
        ];

        $this->assertEquals($data, $result);
        $this->assertNotEmpty($result);

    }

    public function testCreateContentUnitReturnsAlreadyExitsException()
    {
        $em = $this->container->get('doctrine.orm.default_entity_manager');
        $user = $this->createFakeUser();
        $em->persist($user);

        $repository = $em->getRepository(ContentUnit::class);
        $contentUnitRepository = Mockery::mock($repository);
        $contentUnitService = new ContentUnitService($contentUnitRepository);

        $contentUnitRepository->shouldReceive('alreadyExists')->andReturn(true);
        $params = [
            'height' => 400,
            'width' => 200
        ];
        $this->setExpectedException(HttpException::class, 'Content unit already created.');
        $result = $contentUnitService->create($params, $user);
    }

    public function testCreateContentUnitReturnsContentUnitEntity()
    {
        $em = $this->container->get('doctrine.orm.default_entity_manager');
        $user = $this->createFakeUser();
        $em->persist($user);
        $contentUnit = $this->createContentUnit($user);

        $repository = $em->getRepository(ContentUnit::class);
        $contentUnitRepository = Mockery::mock($repository);
        $contentUnitService = new ContentUnitService($contentUnitRepository);

        $contentUnitRepository->shouldReceive('create')->andReturn($contentUnit);
        $params = [
            'height' => 400,
            'width' => 200
        ];
        $result = $contentUnitService->create($params, $user);
        $this->assertInstanceOf(ContentUnit::class, $result);
    }

    public function testDeleteContentUnitWillThrowException()
    {
        $em = $this->container->get('doctrine.orm.default_entity_manager');
        $repository = $em->getRepository(ContentUnit::class);
        $contentUnitRepository = Mockery::mock($repository);
        $contentUnitService = new ContentUnitService($contentUnitRepository);

        $user = $this->createFakeUser();
        $em->persist($user);
        $contentUnitRepository->shouldReceive('delete')->andReturn(false);
        $this->setExpectedException(HttpException::class, 'Couldn\'t delete the entity');
        $contentUnitService->delete(1, $user);
    }

    public function testDeleteContentUnitSuccess()
    {
        $em = $this->container->get('doctrine.orm.default_entity_manager');
        $repository = $em->getRepository(ContentUnit::class);
        $contentUnitRepository = Mockery::mock($repository);
        $contentUnitService = new ContentUnitService($contentUnitRepository);

        $user = $this->createFakeUser();
        $em->persist($user);
        $contentUnitRepository->shouldReceive('delete')->andReturn(true);
        $expected = ['message' => 'Content unit deleted successfully.', 'statusCode' => Codes::HTTP_OK];
        $result = $contentUnitService->delete(1, $user);
        $this->assertEquals($expected, $result);
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

    /**
     * @param User $user
     * @return ContentUnit
     */
    protected function createContentUnit(User $user)
    {
        $contentUnit = new ContentUnit();
        $contentUnit->setHeight(400)
            ->setWidth(200)
            ->setUser($user);

        return $contentUnit;
    }
}
