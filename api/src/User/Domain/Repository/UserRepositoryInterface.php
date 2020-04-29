<?php
declare(strict_types=1);

namespace App\User\Domain\Repository;

use App\User\Domain\Model\UserInterface;
use Ramsey\Uuid\UuidInterface;

interface UserRepositoryInterface
{
    public function add(UserInterface $user) : void;

    public function findOneByName(string $name) : ?UserInterface;

    public function find(UuidInterface $customerId) : ?UserInterface;
}
