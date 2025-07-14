<?php

namespace App\Services;

use App\Contracts\Repositories\UserRepositoryInterface;

class UserService
{
    protected $userRepository;

    public function __construct(UserRepositoryInterface $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    public function create($name, $email, $password = null)
    {
        return $this->userRepository->create([
            'name' => $name,
            'email' => $email,
            'password' => $password,
        ]);
    }
}
