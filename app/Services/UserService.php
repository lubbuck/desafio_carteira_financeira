<?php

namespace App\Services;

use Illuminate\Support\Str;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class UserService
{
    public function create($name, $email, $password = null)
    {
        $user = User::create([
            'name' => $name,
            'email' => $email,
            'password' =>  Hash::make($password ?? Str::random(8))
        ]);

        return $user;
    }
}
