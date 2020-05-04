<?php
declare(strict_types=1);

namespace App\Activity\Domain\Model;

use App\Common\Traits\UuidTrait;
use DateTimeImmutable;

final class Marker
{
    use UuidTrait;

    private Activity $activity;

    private DateTimeImmutable $at;

    public function __construct(Activity $activity, DateTimeImmutable $at)
    {
        $this->activity = $activity;
        $this->at = $at;
    }
}
