<?php

namespace AppBundle\Command;

use AppBundle\Entity\User;
use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;

class CreateUserCommand extends ContainerAwareCommand
{
    protected function configure()
    {
        $this
            ->setName('app:create-user')
            ->setDescription('Creates a new user.')
            ->setHelp('This command allows you to create a user...')
            ->addArgument('username', InputArgument::REQUIRED, 'The username')
            ->addArgument('email', InputArgument::REQUIRED, 'The email')
            ->addArgument('password', InputArgument::REQUIRED, 'The password')
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $username = $input->getArgument('username');
        $email = $input->getArgument('email');
        $password = $input->getArgument('password');

        $user = new User();
        $user
            ->setUsername($username)
            ->setEmail($email)
            ->setPassword(
                $this->getContainer()->get('security.password_encoder')->encodePassword($user, $password)
            )
        ;

        $this->getContainer()->get('app.service.user')->createOrUpdateUser($user);

        $clientManager = $this->getContainer()->get('fos_oauth_server.client_manager.default');
        $client = $clientManager->createClient();
        $client->setRedirectUris(['http://www.miniwave.me']);
        $client->setAllowedGrantTypes(['password']);
        $clientManager->updateClient($client);

        $output->writeln('Username: '.$user->getUsername());
        $output->writeln('Password: '.$password);
        $output->writeln('Client id: '.$client->getPublicId().'_'.$client->getRandomId());
        $output->writeln('Client secret: '.$client->getSecret());
    }
}