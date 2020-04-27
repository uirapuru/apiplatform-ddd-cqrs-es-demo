<?php

namespace App\User\Domain\Model;

use App\Common\Traits\Timestampable;
use App\Common\Traits\UuidTrait;
use DateTimeImmutable;
use Ramsey\Uuid\Uuid;
use Ramsey\Uuid\UuidInterface;

abstract class AbstractUser implements UserInterface
{
    use UuidTrait, Timestampable;

    protected string $username;
    protected FullName $fullName;
    protected EmailAddress $email;
    protected string $password;
    protected string $salt;

    protected function __construct(
        UuidInterface $id,
        string $username,
        FullName $fullName,
        EmailAddress $email,
        string $password,
        string $salt
    ) {
        $this->id = $id ?? Uuid::uuid4();

        $this->username = $username;
        $this->fullName = $fullName;
        $this->email = $email;
        $this->password = $password;
        $this->salt = $salt;

        $this->createdAt = new DateTimeImmutable("now");
        $this->updatedAt = new DateTimeImmutable("now");
    }

    public static function create(
        string $username,
        FullName $fullName,
        EmailAddress $email,
        string $password,
        string $salt,
        ?UuidInterface $id = null
    ) : self
    {
        return new static(
            $id ?? Uuid::uuid4(),
            $username,
            $fullName,
            $email,
            $password,
            $salt
        );
    }

    public function getRoles()
    {
        return ['ROLE_USER'];
    }

    public function getPassword()
    {
        return $this->password;
    }

    public function getSalt()
    {
        return $this->salt;
    }

    public function getUsername()
    {
        return $this->username;
    }

    public function eraseCredentials()
    {
        // TODO: Implement eraseCredentials() method.
    }

    public function fullName(): FullName
    {
        return $this->fullName;
    }

    public function id(): UuidInterface
    {
        return $this->id;
    }

    public function email(): EmailAddress
    {
        return $this->email;
    }
}
