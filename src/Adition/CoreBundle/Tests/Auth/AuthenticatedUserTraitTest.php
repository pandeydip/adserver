<?php

namespace Adition\CoreBundle\Tests\Auth;


use Mockery;
use Adition\AdBundle\Entity\User;
use Adition\AdBundle\Tests\Service\TestCase;
use Symfony\Component\HttpFoundation\Request;
use Adition\AdBundle\Service\UserManagerService;
use Adition\CoreBundle\Auth\AuthenticatedUserTrait;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\HttpKernel\Exception\UnauthorizedHttpException;

class AuthenticatedUserTraitTest extends TestCase
{

    public function testGetAuthUserWillThrowExceptionIfNotAuthenticated()
    {
        $mock = $this->getMockForTrait(AuthenticatedUserTrait::class);

        $container = Mockery::mock(ContainerInterface::class);
        $userManager = Mockery::mock(UserManagerService::class);
        $userManager->shouldReceive('getUser')->andReturnNull();
        $container->shouldReceive('get')->andReturn($userManager);

        $mock->expects($this->atLeastOnce())
            ->method('getContainer')->willReturn($container);
        $this->setExpectedException(UnauthorizedHttpException::class);


        $result = $mock->getAuthUser(new Request());
    }

    public function testGetAuthUserWillReturnUser()
    {
        $mock = $this->getMockForTrait(AuthenticatedUserTrait::class);

        $container = Mockery::mock(ContainerInterface::class);
        $userManager = Mockery::mock(UserManagerService::class);

        $userManager->shouldReceive('getUser')->andReturn($this->getDummyUser());
        $container->shouldReceive('get')->andReturn($userManager);

        $mock->expects($this->atLeastOnce())
            ->method('getContainer')->willReturn($container);

        $result = $mock->getAuthUser(new Request());

        $this->assertInstanceOf(User::class, $result);
    }

    private function getDummyUser()
    {
        $user = new User();
        $user->setPassword('hello')
            ->setUsername('world');

        return $user;
    }
}
