<?php

namespace App\Repositories;

use App\Product;
use Yish\Generators\Foundation\Repository\Repository;

class ProductRepository extends Repository
{
    protected $product;
    static $allProducts;

    public function __construct(Product $product)
    {
        $this->product = $product;
        self::$allProducts = Product::all();
    }

    public function getOneProductByORM($id)
    {
        return Product::findOrFail($id);
    }


}
