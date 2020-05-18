<?php
declare(strict_types=1);

namespace App\Entry\Domain\Repository;

use App\Entry\Domain\Model\Entry;
use Ramsey\Uuid\UuidInterface;

interface EntryRepositoryInterface
{
    public function add(Entry $entry) : void;

    public function find(UuidInterface $uuid) : ?Entry;
}
