<?php
declare(strict_types=1);

namespace App\Activity\Domain\Model;

use App\Common\Traits\UuidTrait;
use Ramsey\Uuid\Uuid;

final class Activity
{
    use UuidTrait;

    private string $name;

    private iterable $markers;

    public function __construct(string $name, iterable $markers)
    {
        $this->id = Uuid::uuid4();
        $this->name = $name;
        $this->markers = $markers;
    }

    public function name(): string
    {
        return $this->name;
    }

    public function markers(): iterable
    {
        return $this->markers;
    }
}
