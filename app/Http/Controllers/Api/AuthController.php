<?php

namespace App\Http\Controllers;

use App\Exceptions\InvalidLoginException;
use App\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class AuthController extends Controller
{

    public function register()
    {
        User::create([
            'name' => request('name'),
            'email' => request('email'),
            'password' => Hash::make(request('password'))
        ]);

        return redirect('/login');
    }

    public function login()
    {
        $user = User::where(['email' => request('email')])->first();

        if (!$user) {
            throw new InvalidLoginException('Invalid login!');
        }

        if (!Hash::check(request('password'), $user->password)) {
            throw new InvalidLoginException('Invalid login!');
        }

        $token = Str::random(80);
        $user->api_token = $token;
        $user->save();

        return ['api_token' => $token];
    }
}
