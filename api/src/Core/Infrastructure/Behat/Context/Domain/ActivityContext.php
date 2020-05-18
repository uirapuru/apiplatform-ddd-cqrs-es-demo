<?php
declare(strict_types=1);

namespace App\Core\Infrastructure\Behat\Context\Domain;

use App\Activity\Domain\Model\Activity;
use App\Activity\Domain\Repository\ActivityRepositoryInterface;
use App\Core\Infrastructure\Behat\Service\SharedStorageInterface;
use Behat\Behat\Context\Context;
use DateTime;
use DateTimeImmutable;

final class ActivityContext implements Context
{
    private SharedStorageInterface $sharedStorage;

    private ActivityRepositoryInterface $activityRepository;

    public function __construct(SharedStorageInterface $sharedStorage, ActivityRepositoryInterface $activityRepository)
    {
        $this->sharedStorage = $sharedStorage;
        $this->activityRepository = $activityRepository;
    }

    /**
     * @Given activity :name at :time is added
     */
    public function activityAtIsAdded(string $name, DateTimeImmutable $time)
    {
        $activity = new Activity($name, [$time]);

        $this->activityRepository->add($activity);

        $this->sharedStorage->set('activity', $activity);
    }

    /**
     * @Transform :time
     */
    public function stringToDatetime(string $time) : DateTimeImmutable
    {
        return new DateTimeImmutable($time);
    }

    /**
     * @Transform :activity
     */
    public function getActivity(string $activity) : Activity
    {
        return new Activity($activity, []);
    }
}
