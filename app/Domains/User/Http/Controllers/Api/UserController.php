<?php
namespace App\Domains\User\Http\Controllers\Api;

use App\Domains\User\Models\User;

class UserController
{
    // This controller will handle user-related API requests.
    public function index()
    {
        return response()->json([
            'users' => User::all()
        ]);
    }
}
