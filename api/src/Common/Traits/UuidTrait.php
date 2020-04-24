<?php
namespace App\Common\Traits;

use Ramsey\Uuid\UuidInterface;

trait UuidTrait
{
    /**
     * @var UuidInterface
     */
    private $id;

    public function id(): UuidInterface
    {
        return $this->id;
    }
}
