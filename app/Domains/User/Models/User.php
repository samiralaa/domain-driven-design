<?php

namespace App\Domains\User\Models;

use Illuminate\Database\Eloquent\Model;
class User extends Model
{
    protected $fillable = ['name', 'email', 'password'];

    // Define any relationships or additional methods here.
}
