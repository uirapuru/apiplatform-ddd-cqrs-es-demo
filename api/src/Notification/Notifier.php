<?php
declare(strict_types=1);

namespace App\Notification;

final class Notifier
{
    private NotifierAdapterInterface $adapter;

    public function __construct(NotifierAdapterInterface $adapter)
    {
        $this->adapter = $adapter;
    }

    public function notify(string $message, Type $type) : void
    {
        $this->adapter->notify($message, $type);
    }
}
