<?php

namespace App\Services;

use App\Repositories\UserRepository;
use Yish\Generators\Foundation\Service\Service;

class UserService extends Service
{
    protected $UserRepository;

    public function __construct(UserRepository $UserRepository)
    {
        $this->UserRepository = $UserRepository;
    }

    public function getAllUsers()
    {
        return $this->UserRepository->getAllUser();
    }

}
