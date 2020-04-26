<?php
namespace App\Common\Traits;

use Ramsey\Uuid\UuidInterface;

trait UuidTrait
{
    private UuidInterface $id;

    public function id(): UuidInterface
    {
        return $this->id;
    }
}
