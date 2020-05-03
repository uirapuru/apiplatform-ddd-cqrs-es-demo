<?php
declare(strict_types=1);

namespace App\Notification;

interface NotifierAdapterInterface
{
    public function notify(string $message, Type $type) : void;
}
