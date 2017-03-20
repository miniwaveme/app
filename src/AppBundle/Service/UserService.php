<?php

namespace AppBundle\Service;

use AppBundle\Entity\User;
use AppBundle\Repository\ORM\UserRepository;

class UserService
{
    /**
     * @var UserRepository
     */
    private $userRepository;

    /**
     * UserService constructor.
     * @param UserRepository $userRepository
     */
    public function __construct(UserRepository $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    /**
     * @param User $user
     * @return User
     */
    public function createOrUpdateUser(User $user)
    {
        return $this->userRepository->update($user);
    }
}