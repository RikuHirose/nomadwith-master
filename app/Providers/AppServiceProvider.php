<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        // User
        $this->app->bind(
            \App\Repositories\UserRepositoryInterface::class,
            \App\Repositories\Eloquent\UserRepository::class
        );

        // Profile
        $this->app->bind(
            \App\Repositories\ProfileRepositoryInterface::class,
            \App\Repositories\Eloquent\ProfileRepository::class
        );

        // Match
        $this->app->bind(
            \App\Repositories\MatchRepositoryInterface::class,
            \App\Repositories\Eloquent\MatchRepository::class
        );

        // Chat
        $this->app->bind(
            \App\Repositories\ChatRepositoryInterface::class,
            \App\Repositories\Eloquent\ChatRepository::class
        );

        // SocialProvider
        $this->app->bind(
            \App\Repositories\SocialProviderRepositoryInterface::class,
            \App\Repositories\Eloquent\SocialProviderRepository::class
        );
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}
