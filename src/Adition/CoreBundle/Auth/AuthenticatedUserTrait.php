<?php

namespace Adition\CoreBundle\Auth;

use Adition\AdBundle\Entity\User;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\HttpKernel\Exception\UnauthorizedHttpException;

trait AuthenticatedUserTrait
{

    /**
     * Gets the Authenticated User.
     *
     * @param Request $request
     * @throws UnauthorizedHttpException if the user is not authenticated
     * @return User
     */
    public function getAuthUser(Request $request)
    {
        $token = $request->headers->get('Authorization');
        $user = $this->getContainer()->get('adition.user_manager')->getUser($token);

        if (!$user instanceof User) {
            throw new UnauthorizedHttpException('', 'Unauthorized Access!');
        }

        return $user;
    }

    /**
     * Gets an instance of the Container
     *
     * @return ContainerInterface
     */
    abstract public function getContainer();
}
