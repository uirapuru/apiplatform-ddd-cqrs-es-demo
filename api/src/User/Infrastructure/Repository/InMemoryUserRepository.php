<?php
declare(strict_types=1);

namespace App\User\Infrastructure\Repository;

use App\User\Domain\Model\FullName;
use App\User\Domain\Model\UserInterface;
use App\User\Domain\Repository\UserRepositoryInterface;
use Ramsey\Uuid\UuidInterface;

class InMemoryUserRepository implements UserRepositoryInterface
{
    private $users = [];

    public function add(UserInterface $user): void
    {
        $this->users[$user->id()->toString()] = $user;
    }

    public function remove(UserInterface $user): void
    {
        unset($this->users[$user->id()->toString()]);
    }

    public function findById(UuidInterface $uuid): ?UserInterface
    {
        return $this->users[$uuid->toString()] ?? null;
    }

    public function findOneByName(string $name): ?UserInterface
    {
        $users = array_filter(
            $this->users,
            fn(UserInterface $user): bool => $user->fullName()->eq(FullName::fromString($name))
        );

        return array_pop($users);
    }

    public function size(): int
    {
        return count($this->users);
    }
}
