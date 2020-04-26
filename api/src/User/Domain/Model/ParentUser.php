<?php

namespace App\User\Domain\Model;

class ParentUser extends AbstractUser implements CustomerInterface
{
    /** @var Member[] */
    protected $children;

    public function __construct(array $children)
    {
        parent::__construct();

        $this->children = $children;
    }

}
