<?php

namespace App\Http\Controllers;


use App\Traits\APIResponser;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;

class ApiController extends Controller
{
    use APIResponser;

    public function __construct()
    {
        $this->middleware('auth:api');
    }

    protected function allowAdminAction()
    {
        if(Gate::denies('admin-action')){
            throw new AuthorizationException("the action is unauthorized");
        }
    }

}
