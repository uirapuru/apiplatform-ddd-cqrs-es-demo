<?php

namespace App\Common\ValueObject;

class Price
{
    /**
     * @var string
     */
    protected $amount;

    /**
     * @var string
     */
    protected $currency = 'PLN';

    public function __construct(string $amount, $currency = 'PLN')
    {
        $this->amount = $amount;
        $this->currency = $currency;
    }

    public static function zero()
    {
        return new self(0, 'PLN');
    }

    public function amount(): string
    {
        return $this->amount;
    }

    public function currency(): string
    {
        return $this->currency;
    }
}
