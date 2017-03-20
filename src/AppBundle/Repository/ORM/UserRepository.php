<?php

namespace AppBundle\Repository\ORM;

use AppBundle\Entity\User;
use Doctrine\ORM\EntityRepository;

class UserRepository extends EntityRepository
{
    /**
     * @param User $user
     * @return User
     */
    public function update(User $user)
    {
        $this->_em->persist($user);
        $this->_em->flush();

        return $user;
    }
}