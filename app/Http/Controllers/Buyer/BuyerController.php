<?php

namespace App\Http\Controllers\Buyer;

use App\Buyer;
use App\Http\Controllers\ApiController;
use App\Services\BuyerService;

class BuyerController extends ApiController
{

    protected $buyerService;

    public function __construct(BuyerService $buyerService)
    {
        $this->buyerService = $buyerService;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $buyers = $this->buyerService->getBuyer();

        return $this->showAll($buyers);
    }


    /**
     * Display the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $buyer = $this->buyerService->getDetailBuyer($id);

        return $this->showOne($buyer);
    }

}
