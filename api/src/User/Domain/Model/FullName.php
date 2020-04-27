<?php
declare(strict_types=1);

namespace App\User\Domain\Model;

use InvalidArgumentException;

final class FullName
{
    protected string $firstName;
    protected string $lastName;

    public function __construct(string $firstName, string $lastName)
    {
        if (ctype_space($firstName) || strlen($firstName) < 2 || strlen($firstName) > 50) {
            throw new InvalidArgumentException('First name should be between 2 and 50 characters length, "' . $firstName . '" given.');
        }

        if (ctype_space($lastName) || strlen($lastName) < 2 || strlen($lastName) > 50) {
            throw new InvalidArgumentException('Last name should be between 2 and 50 characters length, "' . $lastName . '" given.');
        }

        $this->firstName = $firstName;
        $this->lastName = $lastName;
    }

    public static function create(string $firstName, string $lastName) : FullName
    {
        return new self(trim($firstName), trim($lastName));
    }

    public static function fromString(string $fullname)
    {
        return self::create(...explode(" ", $fullname));
    }

    public function __toString() : string
    {
        return $this->getName();
    }

    public function getName() : string
    {
        return $this->firstName . ' ' . $this->lastName;
    }

    public function eq(FullName $compare) : bool
    {
        return (string) $this === (string) $compare;
    }
}
