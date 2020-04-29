<?php
declare(strict_types=1);

namespace App\Order\Domain\Model;

use MyCLabs\Enum\Enum;

/**
 * @method static NEW()
 * @method static PAID()
 * @method static REJECTED()
 */
final class Status extends Enum
{
    private const NEW = 'new';
    private const PAID = 'paid';
    private const REJECTED = 'rejected';
}
