<?php

declare(strict_types=1);

namespace App\Shared\Presentation\Http\Exception;

use Exception;

class InputValidationException extends Exception
{
    /**
     * @var array
     */
    private array $violations;

    public function __construct(array $violations)
    {
        $this->violations = $violations;
        parent::__construct('Validation Exception. Use ::getViolations for more details.');
    }

    public function getViolations(): array
    {
        return $this->violations;
    }
}
