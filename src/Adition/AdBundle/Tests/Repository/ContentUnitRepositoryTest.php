<?php
/**
 * @author Deepak Pandey
 */

namespace Adition\AdBundle\Tests\Repository;

use Adition\AdBundle\Entity\User;
use Adition\AdBundle\Entity\ContentUnit;

class ContentUnitRepositoryTest extends RepositoryTestCase

{

    public function testCreateContentUnit()
    {
        /** @var User $user */
        $user = $this->createUser();

        /** @var ContentUnit $contentUnit */
        $contentUnit = $this->createContentUnit($user);

        /** @var ContentUnit $contentUnitData */
        $contentUnitData = $this->em->getRepository(ContentUnit::class)->find($contentUnit->getId());
        $this->assertEquals($contentUnit->getHeight(), $contentUnitData->getHeight());
        $this->assertEquals($contentUnit->getWidth(), $contentUnitData->getWidth());
        $this->assertEquals($user, $contentUnit->getUser());
    }


    public function testCampaignUnitAlreadyExists()
    {
        /** @var User $user */
        $user = $this->createUser();

        /** @var ContentUnit $contentUnit */
        $this->createContentUnit($user);

        $contentUnitData = $this->em->getRepository(ContentUnit::class)->findOneBy([
            'height' => 100,
            'width' => 200,
            'user' => $user
        ]);

        $this->assertInstanceOf(ContentUnit::class, $contentUnitData);
    }

    public function testDeleteCampaignUnit()
    {
        /** @var User $user */
        $user = $this->createUser();

        /** @var ContentUnit $contentUnit */
        $contentUnit = $this->createContentUnit($user);

        $contentUnitData = $this->em->getRepository(ContentUnit::class)->findOneBy([
            'id' => $contentUnit->getId(),
            'user' => $user
        ]);

        $this->em->remove($contentUnitData);

        $contentUnitAfterDel = $this->em->getRepository(ContentUnit::class)->findOneBy([
            'id' => $contentUnit->getId(),
            'user' => $user
        ]);
    }

    /**
     * @param User $user
     * @return ContentUnit
     */
    protected function createContentUnit(User $user)
    {
        $contentUnit = new ContentUnit();
        $contentUnit->setHeight(100);
        $contentUnit->setWidth(200);
        $contentUnit->setUser($user);
        $this->em->persist($contentUnit);
        $this->em->flush();

        return $contentUnit;
    }

    /**
     * @return User
     */
    private function createUser()
    {
        $user = new User();
        $user->setUsername(uniqid('username', 5));
        $user->setPassword(md5('pass'));
        $this->em->persist($user);
        $this->em->flush();

        return $user;
    }

    protected function getTables()
    {
        return ['content_unit', 'user'];
    }
}
