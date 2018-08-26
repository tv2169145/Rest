<?php

namespace App\Services;

use App\Repositories\ProductRepository;
use Yish\Generators\Foundation\Service\Service;

class ProductService extends Service
{
    protected $productRepository;
    static $allProducts;


    public function __construct(ProductRepository $productRepository)
    {
        $this->productRepository = $productRepository;
        self::$allProducts = ProductRepository::$allProducts;
    }

    public function getAllProducts()
    {
        return self::$allProducts;
    }

    public function getDetailProduct($id)
    {
        $product = $this->productRepository->getOneProductByORM($id);
        return $product;
    }

    //
}
