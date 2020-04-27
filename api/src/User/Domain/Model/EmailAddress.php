<?php
declare(strict_types=1);

namespace App\User\Domain\Model;

use InvalidArgumentException;

final class EmailAddress
{
    protected string $value;

    public function __construct(string $emailAddress)
    {
        if (!filter_var($emailAddress, FILTER_VALIDATE_EMAIL)) {
            throw new InvalidArgumentException('Email address "' . $emailAddress . '" is not valid email address.');
        }

        $this->value = $emailAddress;
    }

    public static function create(string $emailAddress): EmailAddress
    {
        return new self(strtolower($emailAddress));
    }

    public function __toString(): string
    {
        return $this->value;
    }

    public function value(): string
    {
        return $this->value;
    }
}
