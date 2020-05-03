<?php
declare(strict_types=1);

namespace App\Notification;

use MyCLabs\Enum\Enum;

/**
 * @method static SUCCESS()
 * @method static ERROR()
 * @method static INFO()
 */
final class Type extends Enum
{
    private const SUCCESS = 'success';
    private const ERROR = 'error';
    private const INFO = 'info';
}
