<?php
declare(strict_types=1);

namespace App\Core\Infrastructure\Behat\Context\Domain;

use App\Core\Infrastructure\Behat\Service\NotificationCheckerInterface;
use App\Notification\Type;
use Behat\Behat\Context\Context;
use Behat\Behat\Tester\Exception\PendingException;

final class NotificationContext implements Context
{
    private NotificationCheckerInterface $checker;

    public function __construct(NotificationCheckerInterface $checker)
    {
        $this->checker = $checker;
    }

    /**
     * @Then he should be notified that voucher has been successfully created
     */
    public function iShouldBeNotifiedThatVoucherHasBeenSuccessfullyCreated()
    {
        $this->checker->checkNotification(
            'Voucher created',
            Type::SUCCESS()
        );
    }

    /**
     * @Then he should be notified that voucher has been rejected
     */
    public function heShouldBeNotifiedThatVoucherHasBeenRejected()
    {
        $this->checker->checkNotification(
            'Payment for voucher was rejected',
            Type::INFO()
        );
    }

    /**
     * @Given he should be notified that entry was successfully created
     */
    public function heShouldBeNotifiedThatEntryWasSuccessfullyCreated()
    {
        $this->checker->checkNotification(
            'Entry created',
            Type::SUCCESS()
        );
    }
}
