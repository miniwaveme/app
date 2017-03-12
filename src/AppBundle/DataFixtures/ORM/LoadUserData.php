<?php

namespace AppBundle\DataFixtures\ORM\LoadFixtures;

use AppBundle\Entity\User;
use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\DependencyInjection\ContainerAwareInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;

class LoadUserData extends AbstractFixture implements FixtureInterface, ContainerAwareInterface, OrderedFixtureInterface
{
    /**
     * @var ContainerInterface
     */
    private $container;

    /**
     * {@inheritdoc}
     */
    public function setContainer(ContainerInterface $container = null)
    {
        $this->container = $container;
    }

    /**
     * {@inheritdoc}
     */
    public function load(ObjectManager $manager)
    {
        $dataSets = [
            [
                'username' => 'mhor',
                'email' => 'maxime.horcholle@gmail.com',
                'password' => 'mhor',
                'roles' => ['ROLE_ADMIN', 'ROLE_USER'],
            ]
        ];

        foreach ($dataSets as $data) {
            $user = new User();
            $user->setUsername($data['username']);
            $user->setEmail($data['email']);

            $user->setPassword($this->container->get('security.password_encoder')->encodePassword(
                $user,
                $data['password']
            ));

            foreach ($data['roles'] as $role) {
                $user->addRole($role);
            }

            $manager->persist($user);
        }

        $manager->flush();
    }

    /**
     * {@inheritdoc}
     */
    public function getOrder()
    {
        return '1';
    }
}