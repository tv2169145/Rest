<?php

namespace App\Http\Controllers\Product;

use App\Category;
use App\Product;
use Illuminate\Http\Request;
use App\Http\Controllers\ApiController;

class ProductCategoryController extends ApiController
{
    public function __construct()
    {
        $this->middleware('client.credentials')->only(['index']);
        $this->middleware('auth:api')->except(['index']);
        $this->middleware('scope:manage-products')->except(['index']);
        $this->middleware('can:add-category,product')->only(['update']);
        $this->middleware('can:delete-category,product')->only(['destroy']);
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Product $product)
    {
        $categories = $product->categories;
        return $this->showAll($categories);
    }


    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Product $product, Category $category)
    {
        //建立或移除多對多關連
        //attach : 建立關聯 重複的也會建立
        //sync : 建立指定關連,其餘關聯全部拿掉
        //syncWithoutDetaching : 建立關聯,原本已有的關連不會重複建立
        $product->categories()->syncWithoutDetaching([$category->id]);

        return $this->showAll($product->categories);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function destroy(Product $product, Category $category)
    {
       if(!$product->categories()->find($category->id)){
        return $this->errorResponse('the category is not belong this product', 404 );
       }

        $product->categories()->detach($category->id);
       return $this->showAll($product->categories);
    }

}
