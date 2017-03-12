<?php

namespace AppBundle\DataFixtures\ORM\LoadFixtures;

use AppBundle\Entity\OAuth\Client;
use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\DependencyInjection\ContainerAwareInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;

class LoadClientData extends AbstractFixture implements FixtureInterface, ContainerAwareInterface, OrderedFixtureInterface
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
                'randomId' => 'vlR3BiY6FTCoEBXw2nApKCQcy7w55CCqNzaK9w4S3rds2OCbAcpHMMjHhitnwWsn',
                'secret' => 'NRL0FdWMo2XEpGdu1HkN72njxfmYKsF17UWqFhpMpgEPER1j24UghLpkfcxaOo8z',
                'name' => 'Test1',
            ],
        ];

        foreach ($dataSets as $data) {

            $clientManager = $this->container->get('fos_oauth_server.client_manager.default');
            /** @var Client $client */
            $client = $clientManager->createClient();

            $client->setRandomId($data['randomId']);
            $client->setSecret($data['secret']);
            $client->setRedirectUris(['http://localhost']);
            $client->setAllowedGrantTypes([
                'client_credentials',
            ]);
        }
    }

    /**
     * {@inheritdoc}
     */
    public function getOrder()
    {
        return '2';
    }
}