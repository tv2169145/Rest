<?php

namespace App\Services;

use App\Repositories\UserRepository;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Support\Facades\Gate;
use Yish\Generators\Foundation\Service\Service;

class UserService extends Service
{
    protected $userRepository;

    public function __construct(UserRepository $UserRepository)
    {
        $this->userRepository = $UserRepository;
    }

    protected function allowAdminAction()
    {
        if(Gate::denies('admin-action')){
            throw new AuthorizationException("the action is unauthorized");
        }
    }


    public function getAllUsers()
    {
        return $this->userRepository->getAllUser();
    }

    public function getOneUser($id)
    {
        $user = $this->userRepository->getOneUser($id);

        return $user;
    }

    public function createUser($data)
    {

        $userData = $data;

        $userData['password'] = bcrypt($userData['password']);
        $userData['verified'] = $this->userRepository->getUnverifiedUser();
        $userData['verification_token'] = $this->userRepository->generateVerificationCode();
        $userData['admin'] = $this->userRepository->getRegularUser();

        $user = $this->userRepository->createUser($userData);

        return $user;
    }

    public function updateUser($data, $id)
    {
        $user = $this->userRepository->getOneUserByORM($id);


        if($data->has('name')){
            $user->name = $data->name;
        }

        if($data->has('email') && $user->email != $data->email){
            $user->verified = $this->userRepository->getUnverifiedUser();
            $user->verification_token = $this->userRepository->generateVerificationCode();
            $user->email = $data->email;
        }

        if($data->has('password')){
            $user->password = bcrypt($data->password);
        }

        if($data->has('admin')){
            $this->allowAdminAction();
            if(!$user->isVerified()){
                 $user->admin = null;
                 return $user;
            }
            $user->admin = $data->admin;
        }

        if(!$user->isDirty()){
           return $user = null;
        }

        return $user;

    }

    public function getOneUserORM($id)
    {
        $user = $this->userRepository->getOneUserByORM($id);
        return $user;
    }

}
