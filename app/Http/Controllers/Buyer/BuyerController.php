<?php

namespace App\Http\Controllers\Buyer;

use App\Http\Controllers\Controller;
use App\Services\BuyerService;

class BuyerController extends Controller
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

        return response()->json(['data' => $buyers], 200);
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
        return response()->json(['data' => $buyer], 200);
    }

}
