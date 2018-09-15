<?php

namespace App\Http\Controllers;


use App\Traits\APIResponser;
use Illuminate\Http\Request;

class ApiController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:api');
    }

    use APIResponser;
}
