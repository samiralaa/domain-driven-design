<?php
namespace App\Domains\User\Repositories;
use App\Domains\User\Entities\User;

interface UserRepositoryInterface
{
    public function findById(int $id): ?User;

    public function save(User $user): void;

    public function all(): array;
}