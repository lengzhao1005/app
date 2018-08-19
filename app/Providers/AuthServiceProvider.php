<?php

namespace App\Providers;

use App\Models\Reply;
use App\Models\Topic;
use App\Models\User;
use App\Policies\ReplyRolicy;
use App\Policies\TopicPolicy;
use App\Policies\UserPolicy;
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
        User::class => UserPolicy::class,
        Topic::class=>TopicPolicy::class,
        Reply::class => ReplyRolicy::class,
    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerPolicies();

        // Passport 的路由
        Passport::routes();
        // access_token 过期时间
        Passport::tokensExpireIn(Carbon::now()->addDays(15));
        // refreshTokens 过期时间
        Passport::refreshTokensExpireIn(Carbon::now()->addDays(30));

        /*\Horizon::auth(function ($request){

            return \Auth::user()->hasRole('Founder');
        });*/
    }
}
