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

    public function getAdminUser()
    {
        $admins = DB::table('users')->where('admin', '=', 'true')->get();

        return $admins;
    }

    //
}
