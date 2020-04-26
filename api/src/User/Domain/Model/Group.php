<?php

namespace App\User\Domain\Model;

class Group
{
    private Instructor $instructor;

    private iterable $members;

    public function __construct(Instructor $instructor, iterable $members)
    {
        $this->instructor = $instructor;
        $this->members = $members;
    }
}
