<?php

namespace App\Voucher\Domain\Model;

use MyCLabs\Enum\Enum;

/**
 * @method static OPEN()
 * @method static DATE_LIMITED()
 * @method static ENTRIES_LIMITED()
 * @method static MONEY_LIMITED()
 */
class Type extends Enum
{
    const OPEN = 'open';
    const DATE_LIMITED = 'date_limited';
    const ENTRIES_LIMITED = 'entries_limited';
    const MONEY_LIMITED = 'money_limited';

    /**
     * @todo
     *
     * możliwe również złożenia:
     * DATE_LIMITED|ENTRIES_LIMITED
     * DATE_LIMITED|MONEY_LIMITED
     */
}
