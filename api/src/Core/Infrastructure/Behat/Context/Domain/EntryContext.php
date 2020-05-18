<?php

namespace App\Core\Infrastructure\Behat\Context\Domain;

use App\Activity\Domain\Model\Activity;
use App\Common\Enum\EntryType;
use App\Core\Domain\Command\EnterActivity;
use App\Core\Infrastructure\Behat\Service\SharedStorageInterface;
use App\Entry\Domain\Model\Entry;
use App\Entry\Domain\Repository\EntryRepositoryInterface;
use App\User\Domain\Model\CustomerInterface;
use Behat\Behat\Context\Context;
use Symfony\Component\Messenger\MessageBusInterface;
use Webmozart\Assert\Assert;

final class EntryContext implements Context
{
    private SharedStorageInterface $sharedStorage;
    private MessageBusInterface $commandBus;
    private EntryRepositoryInterface $entryRepository;

    public function __construct(
        SharedStorageInterface $sharedStorage,
        EntryRepositoryInterface $entryRepository,
        MessageBusInterface $commandBus
    ) {
        $this->sharedStorage = $sharedStorage;
        $this->commandBus = $commandBus;
        $this->entryRepository = $entryRepository;
    }

    /**
     * @When :user enters :activity
     */
    public function userEnters(CustomerInterface $user, Activity $activity)
    {
        $this->commandBus->dispatch(new EnterActivity(
            $activity->id(),
            $user->id()
        ));
    }

    /**
     * @Then entry is added
     */
    public function entryIsAdded()
    {
        /** @var Entry[] $entries */
        $entries = $this->entryRepository->findAll();

        $entry = array_pop($entries);

        Assert::notNull($entry);

        $this->sharedStorage->set("last_entry", $entry);
    }

    /**
     * @Given created entry is :type type
     */
    public function createdEntryIsType(string $type)
    {
        /** @var Entry $entry */
        $entry = $this->sharedStorage->get("last_entry");

        Assert::eq($entry->type(), new EntryType($type));
    }

}
