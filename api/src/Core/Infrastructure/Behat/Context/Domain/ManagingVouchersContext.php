<?php

namespace App\Core\Infrastructure\Behat\Context\Domain;

use App\Common\ValueObject\Price;
use App\Core\Infrastructure\Behat\Service\SharedStorageInterface;
use App\Payment\Domain\Repository\PaymentRepositoryInterface;
use App\User\Domain\Model\CustomerInterface;
use App\User\Domain\Repository\UserRepositoryInterface;
use App\Voucher\Domain\Command\CreateVoucher;
use App\Voucher\Domain\Model\Type;
use App\Voucher\Domain\Repository\VoucherRepositoryInterface;
use Behat\Behat\Context\Context;
use Behat\Behat\Tester\Exception\PendingException;
use Ramsey\Uuid\Uuid;
use Symfony\Component\Messenger\MessageBusInterface;

class ManagingVouchersContext implements Context
{
    private SharedStorageInterface $sharedStorage;
    private UserRepositoryInterface $userRepository;
    private VoucherRepositoryInterface $voucherRepository;
    private PaymentRepositoryInterface $paymentRepository;
    private MessageBusInterface $bus;

    public function __construct(
        SharedStorageInterface $sharedStorage,
        UserRepositoryInterface $userRepository,
        VoucherRepositoryInterface $voucherRepository,
        PaymentRepositoryInterface $paymentRepository,
        MessageBusInterface $bus
    ) {
        $this->sharedStorage = $sharedStorage;
        $this->userRepository = $userRepository;
        $this->voucherRepository = $voucherRepository;
        $this->paymentRepository = $paymentRepository;
        $this->bus = $bus;
    }

    /**
     * @When I sell voucher for user :user
     */
    public function iSellVoucherForUser(CustomerInterface $user)
    {
        $this->sharedStorage->set("sell_to", $user);
    }

    /**
     * @Given I set its price to :price
     */
    public function iSetItsPriceTo(string $price)
    {
        $this->sharedStorage->set("sell_price", Price::fromString($price));
    }

    /**
     * @Given /^I specify that it was cash paid$/
     */
    public function iSpecifyThatItWasCashPaid()
    {

    }

    /**
     * @Given /^I add it$/
     */
    public function iAddIt()
    {
        $this->bus->dispatch(new CreateVoucher(
            $this->sharedStorage->get('sell_to'),
            Type::OPEN(),
            Uuid::uuid4(),
            null,
            null,
            null,
            null
        ));
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
