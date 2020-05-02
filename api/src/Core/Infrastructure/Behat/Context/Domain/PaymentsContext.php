<?php

namespace App\Core\Infrastructure\Behat\Context\Domain;

use App\Core\Infrastructure\Behat\Service\SharedStorageInterface;
use App\Payment\Domain\Model\Status;
use App\Payment\Domain\Repository\PaymentRepositoryInterface;
use App\User\Domain\Model\CustomerInterface;
use Behat\Behat\Context\Context;
use Webmozart\Assert\Assert;

final class PaymentsContext implements Context
{
    private SharedStorageInterface $sharedStorage;
    private PaymentRepositoryInterface $paymentRepository;

    public function __construct(
        SharedStorageInterface $sharedStorage,
        PaymentRepositoryInterface $paymentRepository
    ) {
        $this->sharedStorage = $sharedStorage;
        $this->paymentRepository = $paymentRepository;
    }

    /**
     * @Given the new payment for user :user should be created
     */
    public function theNewPaymentForUserShouldBeCreated(CustomerInterface $user)
    {
        $payments = $this->paymentRepository->findByUser($user);
        $payment = array_pop($payments);

        Assert::notNull($payment);

        $this->sharedStorage->set("last_payment", $payment);
    }

    /**
     * @Given the payment should be done.
     */
    public function thePaymentShouldBeDone()
    {
        Assert::eq(Status::DONE(), $this->sharedStorage->get("last_payment")->status());
    }
}
