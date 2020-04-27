<?php

namespace App\User\Infrastructure\Repository;

use App\User\Domain\Model\FullName;
use App\User\Domain\Model\UserInterface;
use App\User\Domain\Repository\UserRepositoryInterface;
use Doctrine\ORM\EntityRepository;

class UserRepository extends EntityRepository implements UserRepositoryInterface
{
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
