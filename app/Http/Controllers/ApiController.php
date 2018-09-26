<?php

namespace App\Http\Controllers;


use App\Traits\APIResponser;
use Illuminate\Http\Request;

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
