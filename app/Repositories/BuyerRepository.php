<?php

namespace App\Repositories;

use App\Buyer;
use Yish\Generators\Foundation\Repository\Repository;

class BuyerRepository extends Repository
{
    protected $buyer;
    static $buyers;

    public function __construct(Buyer $buyer)
    {
        $this->buyer = $buyer;
        self::$buyers = $buyer->has('transactions')->get();
    }

    public function getDetailBuyer($id)
    {
        $buyer = Buyer::has('transactions')->findOrFail($id);

        return $buyer;
    }

}
