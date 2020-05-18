<?php
declare(strict_types=1);

namespace App\Entry\Infrastructure\Repository;

use App\Entry\Domain\Model\Entry;
use App\Entry\Domain\Repository\EntryRepositoryInterface;
use App\User\Domain\Model\CustomerInterface;
use Ramsey\Uuid\UuidInterface;

class InMemoryEntryRepository implements EntryRepositoryInterface
{
    private array $entries = [];

    public function add(Entry $entry): void
    {
        $this->entries[$entry->id()->toString()] = $entry;
    }

    public function remove(Entry $entry): void
    {
        unset($this->entries[$entry->id()->toString()]);
    }

    public function find(UuidInterface $uuid): ?Entry
    {
        return $this->entries[$uuid->toString()] ?? null;
    }

    public function findAll(): iterable
    {
        return $this->entries;
    }

    public function findByUser(CustomerInterface $user) : iterable
    {
        return array_filter($this->entries, fn(Entry $entry): bool => $user == $entry->customer());
    }

    public function findByPaymentId(UuidInterface $paymentId): ?Entry
    {
        $collection = array_filter($this->entries, fn(Entry $entry): bool => $paymentId == $entry->payment()->id());

        return array_pop($collection);
    }

    public function size(): int
    {
        return count($this->entries);
    }
}
