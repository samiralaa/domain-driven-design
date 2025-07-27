<?php

namespace App\Domains\User\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function index()
    {
        // Logic to retrieve and return a list of users
        return response()->json(['message' => 'List of users']);
    }
}
