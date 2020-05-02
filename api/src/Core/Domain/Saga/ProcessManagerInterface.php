<?php
declare(strict_types=1);

namespace App\Core\Domain\Saga;

use Ramsey\Uuid\UuidInterface;

interface ProcessManagerInterface
{
    public function processId() : UuidInterface;
}
