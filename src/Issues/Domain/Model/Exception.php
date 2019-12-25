<?php

declare(strict_types=1);

namespace App\Issues\Domain\Model;

class Exception
{
    private string $class;
    private string $message;

    private function __construct(ExceptionClass $class, ExceptionMessage $message)
    {
        $this->class = $class->value();
        $this->message = $message->value();
    }
    public static function create(ExceptionClass $class, ExceptionMessage $message)
    {
        return new self($class, $message);
    }

    public function getClass(): ExceptionClass
    {
        return ExceptionClass::fromString($this->class);
    }

    public function getMessage(): ExceptionMessage
    {
        return ExceptionMessage::fromString($this->message);
    }
}
