<?php

namespace App\User\Entity;

class ParentUser extends AbstractUser
{
    /** @var Member[] */
    protected $children;

    public function __construct(array $children)
    {
        parent::__construct();

        $this->children = $children;
    }

}
