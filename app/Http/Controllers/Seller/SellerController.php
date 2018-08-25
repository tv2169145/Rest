<?php

namespace App\Http\Controllers\Seller;

use App\Services\SellerService;
use Illuminate\Http\Request;
use App\Http\Controllers\ApiController;

class SellerController extends ApiController
{
    protected $sellerService;

    public function __construct(SellerService $sellerService)
    {
        $this->sellerService = $sellerService;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $sellers = $this->sellerService->getSellers();

        return $this->showAll($sellers);

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $seller = $this->sellerService->getDetailSeller($id);
        return $this->showOne($seller);
    }
}
