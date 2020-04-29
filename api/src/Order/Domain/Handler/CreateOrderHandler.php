<?php
declare(strict_types=1);

namespace App\Order\Domain\Handler;

use App\Order\Domain\Command\CreateOrder;
use App\Order\Domain\Event\OrderWasCreated;
use App\Order\Domain\Model\Order;
use App\Order\Domain\Repository\OrderRepositoryInterface;
use App\User\Domain\Repository\UserRepositoryInterface;
use Ramsey\Uuid\Uuid;
use Symfony\Component\Messenger\MessageBusInterface;
use Webmozart\Assert\Assert;

final class CreateOrderHandler
{
    private OrderRepositoryInterface $orderRepository;
    private MessageBusInterface $eventBus;
    private UserRepositoryInterface $userRepository;

    public function __construct(OrderRepositoryInterface $orderRepository, MessageBusInterface $eventBus, UserRepositoryInterface $userRepository)
    {
        $this->orderRepository = $orderRepository;
        $this->eventBus = $eventBus;
        $this->userRepository = $userRepository;
    }

    public function __invoke(CreateOrder $createOrder)
    {
        $customer = $this->userRepository->find($createOrder->customerId());

        Assert::notNull($customer);

        $this->orderRepository->add(new Order(
            $createOrder->orderId(),
            $createOrder->products(),
            $customer
        ));

//        $this->eventBus->dispatch(new OrderWasCreated(Uuid::uuid4(), $createOrder->orderId()));
    }
}
