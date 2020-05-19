<?php
declare(strict_types=1);

namespace App\Voucher\Domain\Model;

use MyCLabs\Enum\Enum;

/**
 * @method static OPEN()
 * @method static DATE_LIMITED()
 * @method static ENTRIES_LIMITED()
 * @method static MONEY_LIMITED()
 */
final class Type extends Enum
{
    private const OPEN = 'open';
    private const DATE_LIMITED = 'date_limited';
    private const ENTRIES_LIMITED = 'entries_limited';
    private const MONEY_LIMITED = 'money_limited';

    /**
     * @todo
     *
     * możliwe również złożenia:
     * DATE_LIMITED|ENTRIES_LIMITED
     * DATE_LIMITED|MONEY_LIMITED
     */
}
