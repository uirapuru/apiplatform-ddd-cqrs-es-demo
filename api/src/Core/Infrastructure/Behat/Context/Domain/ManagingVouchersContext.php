<?php

namespace App\Core\Infrastructure\Behat\Context\Domain;

use App\Common\ValueObject\Price;
use App\Core\Domain\Command\PayPayment;
use App\Core\Domain\Command\PlaceOrderForVoucher;
use App\Core\Domain\Command\RejectPayment;
use App\Core\Infrastructure\Behat\Service\SharedStorageInterface;
use App\Core\Domain\Command\PlacePaidOrderForVoucher;
use App\Payment\Domain\Repository\PaymentRepositoryInterface;
use App\User\Domain\Model\CustomerInterface;
use App\User\Domain\Model\UserInterface;
use App\User\Domain\Repository\UserRepositoryInterface;
use App\Voucher\Domain\Model\Type;
use App\Voucher\Domain\Model\Voucher;
use App\Voucher\Domain\Repository\VoucherRepositoryInterface;
use Behat\Behat\Context\Context;
use Behat\Behat\Tester\Exception\PendingException;
use DateTimeImmutable;
use Ramsey\Uuid\Uuid;
use Symfony\Component\Messenger\MessageBusInterface;
use Webmozart\Assert\Assert;
use App\Payment\Domain\Model\Type as PaymentType;

final class ManagingVouchersContext implements Context
{
    private SharedStorageInterface $sharedStorage;
    private UserRepositoryInterface $userRepository;
    private VoucherRepositoryInterface $voucherRepository;
    private PaymentRepositoryInterface $paymentRepository;
    private MessageBusInterface $commandBus;
    private DateTimeImmutable $now;

    public function __construct(
        SharedStorageInterface $sharedStorage,
        UserRepositoryInterface $userRepository,
        VoucherRepositoryInterface $voucherRepository,
        PaymentRepositoryInterface $paymentRepository,
        MessageBusInterface $commandBus,
        DateTimeImmutable $now
    ) {
        $this->sharedStorage = $sharedStorage;
        $this->userRepository = $userRepository;
        $this->voucherRepository = $voucherRepository;
        $this->paymentRepository = $paymentRepository;
        $this->commandBus = $commandBus;
        $this->now = $now;
    }

    /**
     * @Given I set its price to :price
     */
    public function iSetItsPriceTo(string $price)
    {
        $this->sharedStorage->set("sell_price", Price::fromString($price));
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
     * @Given voucher should be active
     */
    public function itShouldBeActive()
    {
        /** @var Voucher $voucher */
        $voucher = $this->voucherRepository->find(
            $this->sharedStorage->get("last_voucher_id")
        );

        Assert::true($voucher->isActive());
    }


    /**
     * @Given I sell it to user :user
     */
    public function iSellItToUser(CustomerInterface $user) : void
    {
        $this->sharedStorage->set("sell_to", $user);
    }

    /**
     * @Given /^customer paid for it$/
     */
    public function customerPaidForIt()
    {
        $this->sharedStorage->set("order_for_voucher", new PlacePaidOrderForVoucher(
            $voucherId = Uuid::uuid4(),
            $this->sharedStorage->get('sell_to')->id(),
            Type::OPEN(),
            $this->sharedStorage->get("sell_price")
        ));

        $this->sharedStorage->set("last_voucher_id", $voucherId);
    }

    /**
     * @Given customer did not paid for it
     */
    public function customerDidNotPaidForIt()
    {
        $this->sharedStorage->set("order_for_voucher", new PlaceOrderForVoucher(
            $voucherId = Uuid::uuid4(),
            $this->sharedStorage->get('sell_to')->id(),
            Type::OPEN(),
            $this->sharedStorage->get("sell_price")
        ));

        $this->sharedStorage->set("last_voucher_id", $voucherId);
    }

    /**
     * @Given /^I add it$/
     */
    public function iAddIt()
    {
        $this->commandBus->dispatch($this->sharedStorage->get("order_for_voucher"));
    }

    /**
     * @Given an order for voucher is placed for user :user
     */
    public function anOrderForVoucherIsPlacedForUser(CustomerInterface $user)
    {
        $this->sharedStorage->set("sell_price", $price = Price::fromString("10 PLN"));
        $this->sharedStorage->set("sell_to", $user);

        $this->customerDidNotPaidForIt();
        $this->iAddIt();
    }

    /**
     * @When /^customer made a payment for it$/
     */
    public function customerMadeAPaymentForIt()
    {
        $this->commandBus->dispatch(new PayPayment(
            $this->sharedStorage->get("last_voucher_id"),
            PaymentType::TRANSFER(),
            $this->sharedStorage->get("sell_price")
        ));
    }

    /**
     * @When /^customer rejects the payment$/
     */
    public function customerRejectsThePayment()
    {
        $this->commandBus->dispatch(new RejectPayment(
            $this->sharedStorage->get("last_voucher_id")
        ));
    }

    /**
     * @Given /^voucher should be inactive$/
     */
    public function voucherShouldBeInactive()
    {
        /** @var Voucher $voucher */
        $voucher = $this->voucherRepository->find(
            $this->sharedStorage->get("last_voucher_id")
        );

        Assert::false($voucher->isActive());
    }

    /**
     * @Given /^voucher should be closed$/
     */
    public function voucherShouldBeClosed()
    {
        /** @var Voucher $voucher */
        $voucher = $this->voucherRepository->find(
            $this->sharedStorage->get("last_voucher_id")
        );

        Assert::true($voucher->isClosed());
    }

    /**
     * @Given voucher should not be closed
     */
    public function voucherShouldNotBeClosed()
    {
        /** @var Voucher $voucher */
        $voucher = $this->voucherRepository->find(
            $this->sharedStorage->get("last_voucher_id")
        );

        Assert::false($voucher->isClosed());
    }

    /**
     * @Given :user has no voucher
     */
    public function hasNoVoucher(CustomerInterface $user)
    {
        $vouchers = $this->voucherRepository->findByMember($user);

        Assert::count($vouchers, 0);
    }

    /**
     * @Given :user has an active :voucherType voucher
     */
    public function hasAnActiveVoucher(CustomerInterface $user, Type $voucherType)
    {
        $voucher = Voucher::create(
            Uuid::uuid4(),
            $user,
            $voucherType,
            $this->now,
            $this->now->modify("+1 month"),
            null
        );

        $voucher->activate();

        $this->voucherRepository->add($voucher);
    }
}
