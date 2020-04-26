<?php
declare(strict_types=1);

namespace App\User\Domain\Repository;

use App\User\Domain\Model\AbstractUser;

interface UserRepositoryInterface
{
    public function store(AbstractUser $user) : void;
}
