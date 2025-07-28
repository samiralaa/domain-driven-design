<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\CustomCacheManager;
class CustomCacheManagerController extends Controller
{


   public function index(CustomCacheManager $cache)
{
    $cache->set('user_1', ['name' => 'Samir']);

    $user = $cache->get('user_1');

    dd($user);
}

}
