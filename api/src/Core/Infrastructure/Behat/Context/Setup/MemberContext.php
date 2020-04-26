<?php
declare(strict_types=1);

namespace App\Core\Infrastructure\Behat\Context\Setup;

use App\Core\Infrastructure\Behat\Service\SecurityServiceInterface;
use App\Core\Infrastructure\Behat\Service\SharedStorageInterface;
use App\User\Domain\Model\Admin;
use App\User\Domain\Model\Member;
use App\User\Domain\Repository\UserRepositoryInterface;
use Behat\Behat\Context\Context;
use Ramsey\Uuid\Uuid;
use Webmozart\Assert\Assert;

final class MemberContext implements Context
{
    private SharedStorageInterface $sharedStorage;

    private UserRepositoryInterface $userRepository;

    public function __construct(
        SharedStorageInterface $sharedStorage,
        UserRepositoryInterface $userRepository
    ) {
        $this->sharedStorage = $sharedStorage;
        $this->userRepository = $userRepository;
    }

    /**
     * @Given /^there is user "([^"]*)" registered$/
     */
    public function thereIsMemberRegistered(string $fullname)
    {
        $uuid = Uuid::uuid4();

        $member = new Member($uuid, $fullname);

        $this->userRepository->store($member);

        $this->sharedStorage->set('member', $member);
    }
}
