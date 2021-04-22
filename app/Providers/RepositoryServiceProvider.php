<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class RepositoryServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        $this->app->bind(\App\Repositories\UserRepository::class, \App\Repositories\UserRepositoryEloquent::class);
        $this->app->bind(\App\Repositories\TweetRepository::class, \App\Repositories\TweetRepositoryEloquent::class);
        $this->app->bind(\App\Repositories\FollowRepository::class, \App\Repositories\FollowRepositoryEloquent::class);
        //:end-bindings:
    }
}
