<?php

namespace App\Core\Infrastructure\Behat\Context\Domain;

use App\Common\ValueObject\Price;
use App\Core\Infrastructure\Behat\Service\SharedStorageInterface;
use App\Order\Domain\Command\PlaceOrderForVoucher;
use App\Payment\Domain\Repository\PaymentRepositoryInterface;
use App\User\Domain\Model\CustomerInterface;
use App\User\Domain\Repository\UserRepositoryInterface;
use App\Voucher\Domain\Model\Type;
use App\Voucher\Domain\Model\Voucher;
use App\Voucher\Domain\Repository\VoucherRepositoryInterface;
use Behat\Behat\Context\Context;
use Behat\Behat\Tester\Exception\PendingException;
use Ramsey\Uuid\Uuid;
use Symfony\Component\Messenger\MessageBusInterface;
use Webmozart\Assert\Assert;

final class ManagingVouchersContext implements Context
{
    private SharedStorageInterface $sharedStorage;
    private UserRepositoryInterface $userRepository;
    private VoucherRepositoryInterface $voucherRepository;
    private PaymentRepositoryInterface $paymentRepository;
    private MessageBusInterface $commandBus;

    public function __construct(
        SharedStorageInterface $sharedStorage,
        UserRepositoryInterface $userRepository,
        VoucherRepositoryInterface $voucherRepository,
        PaymentRepositoryInterface $paymentRepository,
        MessageBusInterface $commandBus
    ) {
        $this->sharedStorage = $sharedStorage;
        $this->userRepository = $userRepository;
        $this->voucherRepository = $voucherRepository;
        $this->paymentRepository = $paymentRepository;
        $this->commandBus = $commandBus;
    }

    /**
     * @Given I set its price to :price
     */
    public function iSetItsPriceTo(string $price)
    {
        $this->sharedStorage->set("sell_price", Price::fromString($price));
    }

    /**
     * @Given I specify that it was cash paid
     */
    public function iSpecifyThatItWasCashPaid()
    {

    }

    /**
     * @Given I add it
     */
    public function iAddIt()
    {
        $voucherId = Uuid::uuid4();

        $this->commandBus->dispatch(new PlaceOrderForVoucher(
            $voucherId,
            $this->sharedStorage->get('sell_to')->id(),
            Type::OPEN()
        ));

        $this->sharedStorage->set("last_voucher_id", $voucherId);
    }

    /**
     * @Then I should be notified that it has been successfully created
     */
    public function iShouldBeNotifiedThatItHasBeenSuccessfullyCreated()
    {
        Assert::notNull($this->sharedStorage->get("voucher_was_added_event"));
    }

    /**
     * @Given the new voucher should appear in the app
     */
    public function theNewVoucherShouldAppearInTheApp()
    {
        $voucher = $this->voucherRepository->find($this->sharedStorage->get("last_voucher_id"));

        Assert::notNull($voucher);

        $this->sharedStorage->set("last_voucher", $voucher);
    }

    /**
     * @Given it should be active
     */
    public function itShouldBeActive()
    {
        /** @var Voucher $voucher */
        $voucher = $this->sharedStorage->get("last_voucher");
        Assert::true($voucher->isActive());
    }

    /**
     * @When /^I place order for voucher$/
     */
    public function iPlaceOrderForVoucher()
    {

    }

    /**
     * @Given I sell it to user :user
     *
     */
    public function iSellItToUser(CustomerInterface $user) : void
    {
        $this->sharedStorage->set("sell_to", $user);
    }

    /**
     * @Then /^I should be notified that voucher has been successfully created$/
     */
    public function iShouldBeNotifiedThatVoucherHasBeenSuccessfullyCreated()
    {
        throw new PendingException();
    }

}
