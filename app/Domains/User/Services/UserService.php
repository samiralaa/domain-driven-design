<?php
namespace App\Domains\User\Services;
use App\Domains\User\Entities\User;
use App\Domains\User\Repositories\UserRepositoryInterface;
class UserService
{
    public function __construct(private UserRepositoryInterface $repository) {}

    public function createUser(string $name, string $email): User
    {
        $user = new User(0, $name, $email);
        $this->repository->save($user);

        return $user;
    }

    public function getUserById(int $id): ?User
    {
        return $this->repository->findById($id);
    }

    public function getAllUsers(): array
    {
        return $this->repository->all();
    }
}