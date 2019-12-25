<?php

declare(strict_types=1);

namespace App\Shared\Presentation\Http\Validation;

use App\Shared\Application\Command\CommandInterface;

interface ActionInterface
{
    public function toCommand(): CommandInterface;
}
