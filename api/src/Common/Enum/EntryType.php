<?php

namespace App\Common\Enum;

use MyCLabs\Enum\Enum;

/**
 * @method static FREE()
 * @method static VOUCHER()
 * @method static PAID()
 * @method static CREDIT()
 */
class EntryType extends Enum
{
    const FREE = 'free';
    const VOUCHER = 'voucher';
    const PAID = 'paid';
    const CREDIT = 'credit';

    /**
     * @todo dodatkowo:
     *
     * VOUCHER_CREDIT = ŚCIĄGANIE Z PRZYSZŁEGO KARNETU
     * VOUCHER_AMOUNT = ŚCIĄGANIE Z LIMITU KWOTOWEGO NA KARNECIE
     * VOUCHER_ENTRY = ŚCIĄGANIE Z LIMITU WEJŚĆ NA KARNECIE
     */
}
