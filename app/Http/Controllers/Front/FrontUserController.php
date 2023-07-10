<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

class FrontUserController extends Controller
{
    public function index()
    {
        $users =  User::all();

        return $users;
    }
}
