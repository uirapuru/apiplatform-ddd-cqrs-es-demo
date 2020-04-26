<?php
declare(strict_types=1);

namespace App\Core\Infrastructure\Behat\Context\Transform;

use App\User\Domain\Repository\UserRepositoryInterface;
use Behat\Behat\Context\Context;
use Webmozart\Assert\Assert;

class UserContext implements Context
{
    private UserRepositoryInterface $userRepository;

    public function __construct(UserRepositoryInterface $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    /**
     * @Transform /^ user "([^"]+)"$/
     * @Transform :user
     */
    public function getUserByName(string $userName)
    {
        $users = $this->userRepository->findByName($userName);

        Assert::eq(count($users), 1, sprintf('%d users has been found with name "%s".', count($users), $userName));

        return $users[0];
    }
}
