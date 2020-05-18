<?php
declare(strict_types=1);

namespace App\Entry\Infrastructure\Repository;

use App\Common\Traits\HasEntityManager;
use App\Entry\Domain\Model\Entry;
use App\Entry\Domain\Repository\EntryRepositoryInterface;
use App\User\Domain\Model\CustomerInterface;
use Ramsey\Uuid\UuidInterface;

class EntryRepository implements EntryRepositoryInterface
{
    use HasEntityManager;

    public function findByUser(CustomerInterface $user): iterable
    {
        // TODO: Implement findByUser() method.
    }

    public function find(UuidInterface $uuid): ?Entry
    {
        // TODO: Implement find() method.
    }

    public function findByPaymentId(UuidInterface $paymentId): ?Entry
    {
        // TODO: Implement findByPaymentId() method.
    }

    public function add(Entry $entry): void
    {
        // TODO: Implement add() method.
    }

    public function remove(Entry $entry): void
    {
        // TODO: Implement remove() method.
    }
}
