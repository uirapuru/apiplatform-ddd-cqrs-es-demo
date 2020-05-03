<?php

namespace App\Core\Infrastructure\Behat\Context\Domain;

use App\Common\ValueObject\Price;
use App\Core\Domain\Command\PayPayment;
use App\Core\Domain\Command\PlaceOrderForVoucher;
use App\Core\Infrastructure\Behat\Service\SharedStorageInterface;
use App\Core\Domain\Command\PlacePaidOrderForVoucher;
use App\Payment\Domain\Repository\PaymentRepositoryInterface;
use App\User\Domain\Model\CustomerInterface;
use App\User\Domain\Repository\UserRepositoryInterface;
use App\Voucher\Domain\Model\Type;
use App\Voucher\Domain\Model\Voucher;
use App\Voucher\Domain\Repository\VoucherRepositoryInterface;
use Behat\Behat\Context\Context;
use Ramsey\Uuid\Uuid;
use Symfony\Component\Messenger\MessageBusInterface;
use Webmozart\Assert\Assert;
use App\Payment\Domain\Model\Type as PaymentType;

final class EntryContext implements Context
{
    private SharedStorageInterface $sharedStorage;
    private UserRepositoryInterface $userRepository;
    private MessageBusInterface $commandBus;

    public function __construct(
        SharedStorageInterface $sharedStorage,
        UserRepositoryInterface $userRepository,
        VoucherRepositoryInterface $voucherRepository,
        MessageBusInterface $commandBus
    ) {
        $this->sharedStorage = $sharedStorage;
        $this->userRepository = $userRepository;
        $this->commandBus = $commandBus;
    }

}
