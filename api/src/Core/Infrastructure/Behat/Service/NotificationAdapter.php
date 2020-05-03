<?php
declare(strict_types=1);

namespace App\Core\Infrastructure\Behat\Service;

use App\Notification\NotifierAdapterInterface;
use App\Notification\Type;

final class NotificationAdapter implements NotifierAdapterInterface
{
    private array $notifications = [];

    public function notify(string $message, Type $type): void
    {
        $this->notifications[] = [$message, $type];
    }

    public function notifications() : iterable {
        return $this->notifications;
    }
}
