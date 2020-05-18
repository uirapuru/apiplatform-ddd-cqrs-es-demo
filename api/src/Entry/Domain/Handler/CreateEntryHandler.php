<?php
declare(strict_types=1);

namespace App\Entry\Domain\Handler;

use App\Entry\Domain\Command\CreateEntry;
use App\Entry\Domain\Model\Entry;
use App\Entry\Domain\Repository\EntryRepositoryInterface;
use Ramsey\Uuid\Uuid;

final class CreateEntryHandler
{
    protected EntryRepositoryInterface $entryRepository;

    public function __construct(EntryRepositoryInterface $entryRepository)
    {
        $this->entryRepository = $entryRepository;
    }

    public function __invoke(CreateEntry $createEntry)
    {
        $entry = new Entry(
            Uuid::uuid4(),
            $createEntry->datetime(),
            $createEntry->type(),
            $createEntry->datetime()
        );

        $this->entryRepository->add($entry);
    }
}
