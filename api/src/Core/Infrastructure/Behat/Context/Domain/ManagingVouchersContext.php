<?php

namespace App\Core\Infrastructure\Behat\Context\Domain;

use App\Core\Infrastructure\Behat\Service\SharedStorageInterface;
use App\Payment\Domain\Repository\PaymentRepositoryInterface;
use App\User\Domain\Repository\UserRepositoryInterface;
use App\Voucher\Domain\Repository\VoucherRepositoryInterface;
use Behat\Behat\Context\Context;
use Behat\Behat\Tester\Exception\PendingException;

class ManagingVouchersContext implements Context
{
    private SharedStorageInterface $sharedStorage;

    private UserRepositoryInterface $userRepository;

    private VoucherRepositoryInterface $voucherRepository;

    private PaymentRepositoryInterface $paymentRepository;

    public function __construct(
        SharedStorageInterface $sharedStorage,
        UserRepositoryInterface $userRepository,
        VoucherRepositoryInterface $voucherRepository,
        PaymentRepositoryInterface $paymentRepository
    ) {
        $this->sharedStorage = $sharedStorage;
        $this->userRepository = $userRepository;
        $this->voucherRepository = $voucherRepository;
        $this->paymentRepository = $paymentRepository;
    }

    /**
     * @Given /^I want to create a new voucher$/
     */
    public function iWantToCreateANewVoucher()
    {
        throw new PendingException();
    }

    /**
     * @When /^I sell it for user "([^"]*)"$/
     */
    public function iSellItForUser($arg1)
    {
        throw new PendingException();
    }

    /**
     * @Given /^I set its price to "([^"]*)"$/
     */
    public function iSetItsPriceTo($arg1)
    {
        throw new PendingException();
    }

    /**
     * @Given /^I specify that it was cash paid$/
     */
    public function iSpecifyThatItWasCashPaid()
    {
        throw new PendingException();
    }

    /**
     * @Given /^I add it$/
     */
    public function iAddIt()
    {
        throw new PendingException();
    }

    /**
     * @Then /^I should be notified that it has been successfully created$/
     */
    public function iShouldBeNotifiedThatItHasBeenSuccessfullyCreated()
    {
        throw new PendingException();
    }

    /**
     * @Given /^the new voucher should appear in the app$/
     */
    public function theNewVoucherShouldAppearInTheApp()
    {
        throw new PendingException();
    }

    /**
     * @Given /^it should be active$/
     */
    public function itShouldBeActive()
    {
        throw new PendingException();
    }

    /**
     * @Given /^the new payment for user "([^"]*)" should be created$/
     */
    public function theNewPaymentForUserShouldBeCreated($arg1)
    {
        throw new PendingException();
    }

    /**
     * @Given /^the payment should be done\.$/
     */
    public function thePaymentShouldBeDone()
    {
        throw new PendingException();
    }
}
