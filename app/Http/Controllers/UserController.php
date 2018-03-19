<?php

namespace App\Http\Controllers;

use App\Transformers\UserTransformer;
use App\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function index()
    {
        $users = User::all();

        return fractal()
            ->collection($users)
            ->transformWith(new UserTransformer())
            ->toArray();

    }
}
