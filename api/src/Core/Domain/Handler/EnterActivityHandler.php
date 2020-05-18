<?php
declare(strict_types=1);

namespace App\Core\Domain\Handler;

use App\Core\Domain\Command\EnterActivity;
use App\Core\Domain\Event\ActivityWasEntered;
use Symfony\Component\Messenger\MessageBusInterface;

final class EnterActivityHandler
{
    private MessageBusInterface $eventBus;

    public function __construct(MessageBusInterface $eventBus)
    {
        $this->eventBus = $eventBus;
    }

    public function __invoke(EnterActivity $enterActivity)
    {
        $this->eventBus->dispatch(new ActivityWasEntered(
            $enterActivity->activityId(),
            $enterActivity->memberId(),
        ));
    }
}
