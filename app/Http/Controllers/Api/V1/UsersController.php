<?php

namespace App\Http\Controllers\Api\V1;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\User;

class UsersController extends Controller
{
    public function index()

    {
        return User::orderBy('name')->where('id', '!=', auth()->user()->id)->get();
    }
}
