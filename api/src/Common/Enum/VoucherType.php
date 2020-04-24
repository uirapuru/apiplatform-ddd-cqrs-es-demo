<?php

namespace App\Common\Enum;

use MyCLabs\Enum\Enum;

class VoucherType extends Enum
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
