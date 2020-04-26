<?php
declare(strict_types=1);

namespace App\Core\Infrastructure\Behat\Context\Setup;

use App\Core\Infrastructure\Behat\Service\SecurityServiceInterface;
use App\Core\Infrastructure\Behat\Service\SharedStorageInterface;
use App\User\Domain\Model\Admin;
use App\User\Domain\Repository\UserRepositoryInterface;
use Behat\Behat\Context\Context;
use Webmozart\Assert\Assert;

final class AdminSecurityContext implements Context
{
    /** @var SharedStorageInterface */
    private $sharedStorage;

    /** @var SecurityServiceInterface */
    private $securityService;

    /** @var UserRepositoryInterface */
    private $userRepository;

    public function __construct(
        SharedStorageInterface $sharedStorage,
        SecurityServiceInterface $securityService,
        UserRepositoryInterface $userRepository
    ) {
        $this->sharedStorage = $sharedStorage;
        $this->securityService = $securityService;
        $this->userRepository = $userRepository;
    }

    /**
     * @Given I am logged in as an administrator
     */
    public function iAmLoggedInAsAnAdministrator()
    {
        $user = new Admin(); // @todo inject factory

        $this->userRepository->add($user);

        $this->securityService->logIn($user);

        $this->sharedStorage->set('administrator', $user);
    }

    /**
     * @Given /^I am logged in as "([^"]+)" administrator$/
     */
    public function iAmLoggedInAsAdministrator($email)
    {
        $user = $this->userRepository->findOneByEmail($email);
        Assert::notNull($user);

        $this->securityService->logIn($user);

        $this->sharedStorage->set('administrator', $user);
    }

    /**
     * @Given I have been logged out from administration
     */
    public function iHaveBeenLoggedOutFromAdministration()
    {
        $this->securityService->logOut();

        $this->sharedStorage->set('administrator', null);
    }
}
