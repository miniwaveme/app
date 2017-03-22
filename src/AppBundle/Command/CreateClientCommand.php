<?php

namespace AppBundle\Command;

use AppBundle\Entity\User;
use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;

class CreateClientCommand extends ContainerAwareCommand
{
    protected function configure()
    {
        $this
            ->setName('app:create-client')
            ->setDescription('Creates a new client.')
            ->setHelp('This command allows you to create a client...')
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $clientManager = $this->getContainer()->get('fos_oauth_server.client_manager.default');
        $client = $clientManager->createClient();
        $client->setRedirectUris(['http://www.miniwave.me']);
        $client->setAllowedGrantTypes(['password']);
        $clientManager->updateClient($client);

        $output->writeln('Client id: '.$client->getPublicId().'_'.$client->getRandomId());
        $output->writeln('Client secret: '.$client->getSecret());
    }
}