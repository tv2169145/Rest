<?php

namespace App\Providers;

use App\Buyer;
use App\Policies\BuyerPolicy;
use App\Policies\ProductPolicy;
use App\Policies\SellerPolicy;
use App\Policies\TransactionPolicy;
use App\Policies\UserPolicy;
use App\Product;
use App\Seller;
use App\Transaction;
use App\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\Gate;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Laravel\Passport\Passport;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array
     */
    protected $policies = [
        Buyer::class => BuyerPolicy::class,
        Seller::class => SellerPolicy::class,
        User::class => UserPolicy::class,
        Transaction::class => TransactionPolicy::class,
        Product::class => ProductPolicy::class,
    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerPolicies();

        //讓passport可用route
        Passport::routes();

        Gate::define('admin-action', function ($user) {
            return $user->isAdmin();
        });

        //設定passport有效時間
        Passport::tokensExpireIn(Carbon::now()->addMinutes(30));
//        Passport::tokensExpireIn(Carbon::now()->addSeconds(30));
        //設定token多久換新的
        Passport::refreshTokensExpireIn(Carbon::now()->addDays(30));
        //隱藏授權
        Passport::enableImplicitGrant();
        //限制各個token能存取的範圍
        Passport::tokensCan([
            'purchase-product' => 'Create a new transaction for a specific product',
            'manage-products' => 'Create, read, update, delete products',
            'manage-account' => 'Read your account data id, name, email, if verified,
             and if admin(cannot read password). Modify your account data (email and password).
             cannot delete your account',
            'read-general' => 'Read general information like purchasing categories , purchasing products 
            , selling products, selling categories, your transactions (purchases and sales) ',
        ]);
    }
}
