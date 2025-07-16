<?php

namespace App\Domains\User\Services;

use App\Domains\User\Repositories\UserRepositoryInterface;

class UserService
{
    protected $repository;

    public function __construct(UserRepositoryInterface $repository)
    {
        $this->repository = $repository;
    }

    // Add your business logic here
}
