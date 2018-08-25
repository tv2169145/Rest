<?php

namespace App\Repositories;

use App\Seller;
use Yish\Generators\Foundation\Repository\Repository;

class SellerRepository extends Repository
{
    protected $seller;
    static $sellers;

    public function __construct(Seller $seller)
    {
        $this->seller = $seller;
        self::$sellers = $seller->has('products')->get();
    }

    public function getDetailSeller($id)
    {
        $seller = Seller::has('products')->findOrFail($id);
        return $seller;
    }

}
