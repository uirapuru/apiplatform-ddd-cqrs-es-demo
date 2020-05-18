<?php

namespace App\User\Domain\Model;

class Member extends AbstractUser implements CustomerInterface
{
    /** @var iterable|Group[]  */
    protected iterable $groups;
}
