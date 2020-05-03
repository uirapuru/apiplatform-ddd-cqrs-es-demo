<?php
declare(strict_types=1);

namespace App\User\Domain\Model;

use Ramsey\Uuid\UuidInterface;

interface CustomerInterface extends UserInterface
{
    public function id() : UuidInterface;
}
