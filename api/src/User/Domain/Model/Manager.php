<?php

namespace App\User\Domain\Model;

class Manager extends AbstractUser implements EmployeeInterface
{
    /** @var Instructor[] */
    protected $instructors;

//    public function __construct(array $instructors)
//    {
//        parent::__construct();
//
//        $this->instructors = $instructors;
//    }
}
