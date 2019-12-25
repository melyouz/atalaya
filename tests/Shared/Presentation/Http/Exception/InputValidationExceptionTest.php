<?php

namespace Tests\Shared\Presentation\Http\Exception;

use App\Shared\Presentation\Http\Exception\InputValidationException;
use PHPUnit\Framework\TestCase;

class InputValidationExceptionTest extends TestCase
{
    public function testGetViolations()
    {
        $violations = ['one', 'two'];
        $exception = new InputValidationException($violations);
        $this->assertEquals($violations, $exception->getViolations());
    }
}
