<?php

namespace App\Domains\User\Repositories;

use App\Domains\User\Entities\User;
use App\Domains\User\Repositories\UserRepositoryInterface;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class EloquentUserRepository implements UserRepositoryInterface
{
    public function findById(int $id): ?User
    {
        $userModel = \App\Models\User::find($id);

        if (!$userModel) {
            return null;
        }

        return new User($userModel->id, $userModel->name, $userModel->email);
    }

    public function save(User $user): void
    {
        \App\Models\User::updateOrCreate(
            ['id' => $user->id],
            ['name' => $user->name, 'email' => $user->email]
        );
    }


    public function all(): array
    {
        $users = \App\Models\User::all();
        return $users->map(fn($userModel) => new User(
            $userModel->id,
            $userModel->name,
            $userModel->email
        ))->toArray();
    }
}
