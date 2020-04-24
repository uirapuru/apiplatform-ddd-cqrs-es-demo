<?php

namespace App\User\Entity;

class Manager extends AbstractUser
{
    /** @var Instructor[] */
    protected $instructors;

    public function __construct(array $instructors)
    {
        parent::__construct();

        $this->instructors = $instructors;
    }
}
