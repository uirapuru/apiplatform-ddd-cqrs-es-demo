<?php
declare(strict_types=1);

namespace App\Core\Infrastructure\Behat\Context\Domain;

use App\Core\Infrastructure\Behat\Service\NotificationCheckerInterface;
use App\Notification\Type;
use Behat\Behat\Context\Context;

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
}
