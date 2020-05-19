<?php
declare(strict_types=1);

namespace App\Payment\Infrastructure\Repository;

use App\Payment\Domain\Model\Payment;
use App\Payment\Domain\Repository\PaymentRepositoryInterface;
use App\User\Domain\Model\CustomerInterface;
use Ramsey\Uuid\UuidInterface;

class InMemoryPaymentRepository implements PaymentRepositoryInterface
{
    private $payments = [];

    public function add(Payment $payment): void
    {
        $this->payments[$payment->id()->toString()] = $payment;
    }

    public function remove(Payment $payment): void
    {
        unset($this->payments[$payment->id()->toString()]);
    }

    public function find(UuidInterface $uuid): ?Payment
    {
        return $this->payments[$uuid->toString()] ?? null;
    }

    public function findByUser(CustomerInterface $user)
    {
        return array_filter($this->payments, fn(Payment $payment): bool => $user == $payment->order()->customer());

    }

    public function size(): int
    {
        return count($this->payments);
    }
}