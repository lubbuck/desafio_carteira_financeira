<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Services\UserService;
use App\Services\CarteiraService;

class DatabaseSeeder extends Seeder
{

    protected $userService;
    protected $carteiraService;

    public function __construct(UserService $userService, CarteiraService $carteiraService)
    {
        $this->userService = $userService;
        $this->carteiraService = $carteiraService;
    }

    public function run(): void
    {
        $user = $this->userService->create('Primeiro', 'primeiro@email.com', '123456789');
        $this->carteiraService->create($user->id);

        $user = $this->userService->create('segundo', 'segundo@email.com', '123456789');
        $this->carteiraService->create($user->id);

        $user = $this->userService->create('terceiro', 'terceiro@email.com', '123456789');
        $this->carteiraService->create($user->id);

        $user = User::create([
            'name' => 'Antonio',
            'email' => 'antonioluisp97@gmail.com',
            'password' => Hash::make('123456789'),
            'is_super_admin' => true, // true se for nós da ctic false para todo o resto
        ]);
        $this->carteiraService->create($user->id);
    }
}
