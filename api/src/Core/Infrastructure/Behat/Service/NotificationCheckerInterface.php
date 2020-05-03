<?php
declare(strict_types=1);

namespace App\Core\Infrastructure\Behat\Service;

use App\Notification\Type;

interface NotificationCheckerInterface
{
    public function checkNotification(string $message, Type $type): void;
}
