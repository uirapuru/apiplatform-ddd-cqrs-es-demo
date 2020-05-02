<?php
declare(strict_types=1);

namespace App\Payment\Domain\Model;

use MyCLabs\Enum\Enum;

/**
 * @method static CASH()
 * @method static TRANSFER()
 */
final class Type extends Enum
{
    private const CASH = 'cash';
    private const TRANSFER = 'tranfer';
}
