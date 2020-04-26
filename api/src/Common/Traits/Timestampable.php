<?php

namespace App\Common\Traits;

use DateTimeImmutable;

trait Timestampable
{
    protected DateTimeImmutable $createdAt;

    protected DateTimeImmutable $updatedAt;

    protected DatetimeImmutable $deletedAt;

}
