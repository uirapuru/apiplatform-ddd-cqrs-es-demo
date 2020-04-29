<?php
declare(strict_types=1);

namespace App\Core\Infrastructure\Behat\Context\Domain;

use App\Core\Infrastructure\Behat\Service\SharedStorageInterface;
use App\Order\Domain\Model\Status;
use App\Order\Domain\Repository\OrderRepositoryInterface;
use App\User\Domain\Model\CustomerInterface;
use Behat\Behat\Context\Context;
use Webmozart\Assert\Assert;

final class OrdersContext implements Context
{
    private SharedStorageInterface $sharedStorage;
    private OrderRepositoryInterface $orderRepository;

    public function __construct(SharedStorageInterface $sharedStorage, OrderRepositoryInterface $orderRepository)
    {
        $this->sharedStorage = $sharedStorage;
        $this->orderRepository = $orderRepository;
    }

    /**
     * @Given the new order for user :user should be created
     */
    public function theNewOrderForUserShouldBeCreated(CustomerInterface $user)
    {
        $orders = $this->orderRepository->findByUser($user);
        $order = array_pop($orders);

        Assert::notNull($order);

        $this->sharedStorage->set("last_order", $order);
    }

    /**
     * @Given it should be paid
     */
    public function itShouldBePaid()
    {
        Assert::eq($this->sharedStorage->get("last_order")->status(), Status::PAID(), 'Status should be "%s" but is "%s"');
    }
}
