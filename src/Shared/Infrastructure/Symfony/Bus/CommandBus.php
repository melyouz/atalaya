<?php

declare(strict_types=1);

namespace App\Shared\Infrastructure\Symfony\Bus;

use App\Shared\Application\Bus\CommandBusInterface;
use App\Shared\Application\Command\CommandInterface;
use Symfony\Component\Messenger\MessageBusInterface;

class CommandBus implements CommandBusInterface
{
    /**
     * @var MessageBusInterface
     */
    private MessageBusInterface $commandBus;

    public function __construct(MessageBusInterface $commandBus)
    {
        $this->commandBus = $commandBus;
    }

    public function dispatch(CommandInterface $command)
    {
        $this->commandBus->dispatch($command);
    }
}
