<?php

namespace App\Common\Traits;

use DateTimeImmutable;

trait Timestampable
{
    /**
     * @var DateTimeImmutable $created
     */
    protected $createdAt;

    /**
     * @var DateTimeImmutable $updatedAt
     */
    protected $updatedAt;

    /**
     * @var DatetimeImmutable $deletedAt
     */
    protected $deletedAt;

}
