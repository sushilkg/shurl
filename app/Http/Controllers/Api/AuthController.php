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
        request()->validate([
            'name' => ['bail', 'string', 'max:255'],
            'email' => ['bail', 'required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['bail', 'required', 'string', 'min:8', 'confirmed']
        ]);

        User::create([
            'name' => request('name'),
            'email' => request('email'),
            'password' => Hash::make(request('password'))
        ]);

        return redirect('/login');
    }

    /**
     * @return array
     * @throws InvalidLoginException
     */
    public function login()
    {
        $user = User::where(['email' => request('email')])->first();

        if (!$user || !Hash::check(request('password'), $user->password)) {
            throw new InvalidLoginException('Invalid login!');
        }

        $token = Str::random(80);
        $user->api_token = $token;
        $user->save();

        return ['api_token' => $token];
    }
}
