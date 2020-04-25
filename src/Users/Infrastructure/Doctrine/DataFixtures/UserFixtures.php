<?php

namespace App\Users\Infrastructure\Doctrine\DataFixtures;

use App\Security\Infrastructure\Provider\SymfonyUserProvider;
use App\Shared\Application\Bus\CommandBusInterface;
use App\Users\Application\Command\ConfirmUserCommand;
use App\Users\Application\Command\RegisterUserCommand;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class UserFixtures extends Fixture
{
    /**
     * @var CommandBusInterface
     */
    private CommandBusInterface $commandBus;
    /**
     * @var SymfonyUserProvider
     */
    private SymfonyUserProvider $userProvider;

    public function __construct(CommandBusInterface $commandBus, SymfonyUserProvider $userProvider)
    {
        $this->commandBus = $commandBus;
        $this->userProvider = $userProvider;
    }

    public function load(ObjectManager $manager)
    {
        $this->registerUser();
        $this->confirmUser();
    }

    private function registerUser(): void
    {
        $id = uuid_create(UUID_TYPE_RANDOM);
        $name = 'John Doe';
        $email = 'john.doe@atalaya.tech';
        $rawPlainPassword = 'john123';

        $command = new RegisterUserCommand($id, $name, $email, $rawPlainPassword);
        $this->commandBus->dispatch($command);
    }

    private function confirmUser(): void
    {
        $user = $this->userProvider->loadUserByUsername('john.doe@atalaya.tech');
        $command = new ConfirmUserCommand($user->getConfirmationToken()->value());
        $this->commandBus->dispatch($command);
    }
}
