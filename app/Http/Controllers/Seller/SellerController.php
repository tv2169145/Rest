<?php

namespace App\Http\Controllers\Seller;

use App\Seller;
use App\Services\SellerService;
use Illuminate\Http\Request;
use App\Http\Controllers\ApiController;

class SellerController extends ApiController
{
    protected $sellerService;

    public function __construct(SellerService $sellerService)
    {
        parent::__construct();
        $this->middleware('scope:read-general')->only(['show']);
        $this->middleware('can:view,seller')->only(['show']);
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
    public function show(Seller $seller )
    {
//        $seller = $this->sellerService->getDetailSeller($id);
        return $this->showOne($seller);
    }
}
