<?php

namespace App\User\Infrastructure\Repository;

use App\Common\Traits\HasEntityManager;
use App\User\Domain\Model\FullName;
use App\User\Domain\Model\UserInterface;
use App\User\Domain\Repository\UserRepositoryInterface;
use Doctrine\ORM\EntityRepository;
use Ramsey\Uuid\UuidInterface;

class UserRepository implements UserRepositoryInterface
{
    use HasEntityManager;

    public function find(UuidInterface $customerId): ?UserInterface
    {
        // TODO: Implement find() method.
    }

    public function add(UserInterface $user): void
    {
        $this->_em->persist($user);
    }

    public function findOneByName(string $name): ?UserInterface
    {
        return $this->findOneBy([
            "fullName" => FullName::create($name)
        ]);
    }
}
