<?php

namespace Adition\AdBundle\Service;

use Adition\AdBundle\Entity\User;
use Adition\AdBundle\Repository\UserRepository;

class UserManagerService
{

    /**
     * @var UserRepository
     */
    private $userRepository;

    /**
     * UserManager constructor.
     *
     * @param UserRepository $userRepository
     */
    public function __construct(UserRepository $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    /**
     * @param $authorizationToken
     * @return User|null|object
     */
    public function getUser($authorizationToken)
    {
        list($username, $password) = $this->decodeAuthorizationHeader($authorizationToken);

        $user = $this->userRepository->findOneBy([
            'username' => $username,
            'password' => md5($password)
        ]);

        return $user;
    }

    /**
     * @param $authorizationToken
     * @return array
     */
    protected function decodeAuthorizationHeader($authorizationToken)
    {
        $data = explode(':', base64_decode(substr(trim($authorizationToken), 6)));

        return $data;
    }
}
