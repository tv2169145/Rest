<?php

namespace App\Http\Controllers\Buyer;

use App\Buyer;
use App\Http\Controllers\ApiController;
use App\Services\BuyerService;
use App\User;

use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Support\Facades\Gate;

class BuyerController extends ApiController
{
    protected $buyerService;

    public function __construct(BuyerService $buyerService)
    {
        parent::__construct();
        $this->middleware('scope:read-general')->only(['index']);
        $this->middleware('can:view,buyer')->only(['show']);
        $this->buyerService = $buyerService;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $this->allowAdminAction();
        $buyers = $this->buyerService->getBuyer();

        return $this->showAll($buyers);
    }


    /**
     * Display the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function show(Buyer $buyer)
    {
//        $buyer = $this->buyerService->getDetailBuyer($id);

        return $this->showOne($buyer);
    }

}
