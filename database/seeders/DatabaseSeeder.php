<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        User::create([
            'name' => 'Primeiro',
            'email' => 'primeiro@email.com',
            'password' => Hash::make('123456789'),
        ]);

        User::create([
            'name' => 'Segundo',
            'email' => 'segundo@email.com',
            'password' => Hash::make('123456789'),
        ]);

        User::create([
            'name' => 'Terceiro',
            'email' => 'terceiro@email.com',
            'password' => Hash::make('123456789'),
        ]);

        User::create([
            'name' => 'Antonio',
            'email' => 'antonioluisp97@gmail.com',
            'password' => Hash::make('123456789'),
            'is_super_admin' => true, // true se for nós da ctic false para todo o resto
        ]);
    }
}
