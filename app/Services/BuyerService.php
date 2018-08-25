<?php

namespace App\Services;

use App\Repositories\BuyerRepository;
use Yish\Generators\Foundation\Service\Service;

class BuyerService extends Service
{
    protected $buyerRepository;
    protected $buyers;

    public function __construct(BuyerRepository $buyerRepository)
    {
        $this->buyerRepository = $buyerRepository;
        $this->buyers = BuyerRepository::$buyers;
    }

    public function getBuyer()
    {
        return $this->buyers;
    }

    public function getDetailBuyer($id)
    {
        $buyer = $this->buyerRepository->getDetailBuyer($id);
        return $buyer;
    }
}
