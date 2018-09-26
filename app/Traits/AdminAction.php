<?php

namespace App\Traits;

use App\User;

trait AdminAction
{
    public function before($user, $ability)
    {
        if($user->isAdmin()){
            return true;
        }
    }

}