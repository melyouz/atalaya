<?php
declare(strict_types=1);

namespace App\Shared\Application\Bus;

use App\Shared\Application\Command\CommandInterface;

interface CommandBusInterface
{
    public function dispatch(CommandInterface $command);
}