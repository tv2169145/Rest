<?php

namespace App\Providers;

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
        'App\Model' => 'App\Policies\ModelPolicy',
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

        //設定passport有效時間
        Passport::tokensExpireIn(Carbon::now()->addMinutes(30));
//        Passport::tokensExpireIn(Carbon::now()->addSeconds(30));
        //設定token多久換新的
        Passport::refreshTokensExpireIn(Carbon::now()->addDays(30));
        //隱藏授權
        Passport::enableImplicitGrant();
    }
}
