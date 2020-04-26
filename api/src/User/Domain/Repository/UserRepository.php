<?php

namespace App\User\Domain\Repository;

use App\User\Domain\Model\AbstractUser;
use Doctrine\ORM\EntityRepository;

class UserRepository extends EntityRepository implements UserRepositoryInterface
{
    public function store(AbstractUser $user): void
    {
        $this->_em->persist($user);
        $this->_em->flush();
    }
}
