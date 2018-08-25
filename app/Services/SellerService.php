<?php

namespace App\Services;

use App\Repositories\SellerRepository;
use Yish\Generators\Foundation\Service\Service;

class SellerService extends Service
{
    protected $sellerRepository;
    protected $sellers;

    public function __construct(SellerRepository $sellerRepository)
    {
        $this->sellerRepository = $sellerRepository;
        $this->sellers = SellerRepository::$sellers;
    }

    public function getSellers()
    {
        return $this->sellers;
    }

    public function getDetailSeller($id)
    {
        $seller = $this->sellerRepository->getDetailSeller($id);
        return $seller;
    }

}
