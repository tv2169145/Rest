<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;


/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

//Route::middleware('auth:api')->get('/user', function (Request $request) {
//    return $request->user();
//});


/**
 * Buyers
 */
Route::resource('buyers', 'Buyer\BuyerController', ['only' => ['index', 'show']]);
Route::resource('buyer.transactions', 'Buyer\BuyerTransactionController', ['only' => ['index']]);
Route::resource('buyer.products', 'Buyer\BuyerProductController', ['only' => ['index']]);
Route::resource('buyer.sellers', 'Buyer\BuyerSellerController', ['only' => ['index']]);
Route::resource('buyer.categories', 'Buyer\BuyerCategoryController', ['only' => ['index']]);

/**
 * Categories
 */
Route::resource('categories', 'Category\CategoryController', ['except' => ['create', 'edit']]);
Route::resource('category.products','Category\CategoryProductController', ['only' => ['index',]]);
Route::resource('category.sellers','Category\CategorySellerController', ['only' => ['index',]]);
Route::resource('category.transactions','Category\CategoryTransactionController', ['only' => ['index',]]);
Route::resource('category.buyers','Category\CategoryBuyerController', ['only' => ['index',]]);

/**
 * Products
 */
Route::resource('products', 'Product\ProductController', ['only' => ['index', 'show']]);
Route::resource('product.transactions', 'Product\ProductTransactionController', ['only' => ['index']]);
Route::resource('product.buyers', 'Product\ProductBuyerController', ['only' => ['index']]);
Route::resource('product.categories', 'Product\ProductCategoryController', ['only' => ['index', 'update', 'destroy']]);
Route::resource('product.buyers.transactions', 'Product\ProductBuyerTransactionController', ['only' => ['store']]);
/**
 * Sellers
 */
Route::resource('sellers', 'Seller\SellerController', ['only' => ['index', 'show']]);
Route::resource('seller.transactions', 'Seller\SellerTransactionController', ['only' => ['index']]);
Route::resource('seller.categories', 'Seller\SellerCategoryController', ['only' => ['index']]);
Route::resource('seller.buyers', 'Seller\SellerBuyerController', ['only' => ['index']]);
Route::resource('seller.products', 'Seller\SellerProductController', ['except' => ['create', 'show', 'edit']]);
/**
 * Transactions
 */
Route::resource('transactions', 'Transaction\TransactionController', ['only' => ['index', 'show']]);
Route::resource('transactions.categories', 'Transaction\TransactionCategoryController',['only'=>['index']]);
Route::resource('transactions.sellers', 'Transaction\TransactionSellerController',['only'=>['index']]);

/**
 * Users
 */
Route::resource('user', 'User\UserController', ['except' => ['create', 'edit']]);
//驗證使用者
Route::name('verify')->get('user/verify/{token}', 'User\UserController@verify');
//重發驗證信
Route::name('resend')->get('user/{user}/resend', 'User\UserController@resend');
//apiToken
Route::post('oauth/token', '\Laravel\Passport\Http\Controllers\AccessTokenController@issueToken');




