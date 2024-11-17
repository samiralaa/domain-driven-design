<?php

namespace App\Http\Controllers\Api\User\Auth;

use App\Domains\User\Services\UserService;
use App\Http\Controllers\Controller;
use App\Http\Requests\User\Auth\AuthRequest;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;


class UserController extends Controller
{
    public function __construct(private UserService $userService) {}

    public function index(): JsonResponse
    {
        $users = $this->userService->getAllUsers();
        return response()->json($users);
    }

    public function show(int $id): JsonResponse
    {
        $user = $this->userService->getUserById($id);

        if (!$user) {
            return response()->json(['error' => 'User not found'], 404);
        }

        return response()->json($user);
    }

    public function store(AuthRequest $request): JsonResponse
    {

        $data = $request->validated();
        $user = $this->userService->createUser($data['name'], $data['email']);
        return response()->json($user, 201);
    }
}
