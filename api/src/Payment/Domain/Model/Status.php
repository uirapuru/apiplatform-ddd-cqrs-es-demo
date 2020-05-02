<?php
declare(strict_types=1);

namespace App\Payment\Domain\Model;

use MyCLabs\Enum\Enum;

/**
 * @method static DONE()
 * @method static WAITING()
 * @method static REJECTED()
 */
final class Status extends Enum
{
    private const DONE = 'done';
    private const WAITING = 'waiting';
    private const REJECTED = 'rejected';
}
