<?php

namespace App\Repositories;

use App\User;
use Illuminate\Support\Facades\DB;
use Yish\Generators\Foundation\Repository\Repository;

class UserRepository extends Repository
{
    protected $user;

    public function __construct(User $user)
    {
        $this->user = $user;
    }

    public function getAllUser()
    {
        return User::all();
    }

    public function getOneUser($id)
    {
        return DB::table('users')->where('id', $id)->get();
    }


    public function getAdminUser()
    {
        $admins = DB::table('users')->where('admin', '=', 'true')->get();

        return $admins;
    }

    public static function getUnverifiedUser()
    {
        return User::UNVERIFIED_USER;
    }

    public static function generateVerificationCode()
    {
        return User::generateVerificationCode();
    }

    public static function getRegularUser()
    {
        return User::REGULAR_USER;
    }

    public function createUser($userData)
    {
        $user = User::create($userData);

        return $user;
    }

    //
}
