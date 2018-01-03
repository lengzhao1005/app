<?php

namespace App\Providers;

use App\Models\Reply;
use App\Models\Topics;
use App\Models\User;
use App\Observers\ReplyObserver;
use App\Observers\TopicObserver;
use App\Observers\UserObserver;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        Topics::observe(TopicObserver::class);
        User::observe(UserObserver::class);
        Reply::observe(ReplyObserver::class);

        Schema::defaultStringLength(191);//数据库编码问题
        \Carbon\Carbon::setLocale('zh');
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }
}
