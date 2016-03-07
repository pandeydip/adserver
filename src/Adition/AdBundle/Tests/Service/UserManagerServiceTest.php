<?php

namespace Adition\AdBundle\Tests\Service;

use Mockery;
use Adition\AdBundle\Entity\User;
use Adition\AdBundle\Service\UserManagerService;

class UserManagerServiceTest extends TestCase
{

    public function testGetUserIfUserIsNotPresentInDatabase()
    {
        /** @var UserManagerService $userManager */
        $userManager = $this->container->get('adition.user_manager');

        $token = 'Basic ZGVlcGFrOnRlc3Qx';
        $user = $userManager->getUser($token);

        $this->assertNull($user);
    }

    public function testGetUserWhenUserExistsInDatabase()
    {
        $em = $this->container->get('doctrine.orm.default_entity_manager');
        $repository = $em->getRepository(User::class);

        $userRepository = Mockery::mock($repository);
        $userManager = new UserManagerService($userRepository);

        $dummy = new User();
        $dummy->setUsername('test')->setPassword('test');
        $userRepository->shouldReceive('findOneBy')->andReturn($dummy);

        $token = 'Basic ZGVlcGFrOnRlc3Qx';
        $user = $userManager->getUser($token);

        $this->assertInstanceOf(User::class, $user);
    }

    public function testDecodeAuthorizationHeader()
    {
        /** @var UserManagerService $userManager */
        $userManager = $this->container->get('adition.user_manager');

        $token = 'Basic ZGVlcGFrOnRlc3Qx';

        list($username, $password) = $this->invokeMethod($userManager, 'decodeAuthorizationHeader', [$token]);

        $this->assertEquals('deepak', $username);
        $this->assertEquals('test1', $password);
    }

}
