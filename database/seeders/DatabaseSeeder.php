<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Contracts\Repositories\{
    UserRepositoryInterface,
    CarteiraRepositoryInterface
};

class DatabaseSeeder extends Seeder
{
    protected $userRepository;
    protected $carteiraRepository;

    public function __construct(UserRepositoryInterface $userRepository, CarteiraRepositoryInterface $carteiraRepository)
    {
        $this->userRepository = $userRepository;
        $this->carteiraRepository = $carteiraRepository;
    }

    public function run(): void
    {
        $user = $this->userRepository->create([
            'name' => 'Primeiro',
            'email' => 'primeiro@email.com',
            'password' => '123456789'
        ]);
        $this->carteiraRepository->create([
            'user_id' => $user->id
        ]);

        $user = $this->userRepository->create([
            'name' => 'Segundo',
            'email' => 'segundo@email.com',
            'password' => '123456789'
        ]);
        $this->carteiraRepository->create([
            'user_id' => $user->id
        ]);

        $user = $this->userRepository->create([
            'name' => 'Terceirop',
            'email' => 'terceirop@email.com',
            'password' => '123456789'
        ]);
        $this->carteiraRepository->create([
            'user_id' => $user->id
        ]);

        $user = $this->userRepository->create([
            'name' => 'Antonio',
            'email' => 'antonioluisp97@gmail.com',
            'password' => '123456789',
            'is_super_admin' => true, // true se for nós da ctic false para todo o resto
        ]);
        $this->carteiraRepository->create([
            'user_id' => $user->id
        ]);
    }
}
