<?php
declare(strict_types=1);

namespace App\Core\Infrastructure\Behat\Context\Transform;

use App\User\Domain\Model\CustomerInterface;
use App\User\Domain\Repository\UserRepositoryInterface;
use Behat\Behat\Context\Context;
use Webmozart\Assert\Assert;

final class UserContext implements Context
{
    private UserRepositoryInterface $userRepository;

    public function __construct(UserRepositoryInterface $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    /**
     * @Transform :user
     */
    public function getUserByName(string $userName) : ?CustomerInterface
    {
        return $this->userRepository->findOneByName($userName);
    }
}
