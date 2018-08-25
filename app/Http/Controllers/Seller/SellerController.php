<?php

namespace App\Http\Controllers\Seller;

use App\Services\SellerService;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class SellerController extends Controller
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

        return response()->json(['data' => $sellers], 200);

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
        return response()->json(['data' => $seller], 200);
    }
}
