<?php
declare(strict_types=1);

namespace App\Core\Infrastructure\Behat\Service;

use App\Notification\NotifierAdapterInterface;
use App\Notification\Type;

final class NotificationChecker implements NotificationCheckerInterface
{
    private NotifierAdapterInterface $notifier;

    public function __construct(NotifierAdapterInterface $notifier)
    {
        $this->notifier = $notifier;
    }

    public function checkNotification(string $message, Type $type): void
    {
        foreach ($this->notifier->notifications() as [$expText, $expType]) {
            if($message == $expText && $type == $expType) {
                return;
            }
        }

        throw new \Exception("Notification not found");
    }
}
