<?php

namespace App\Providers;

use App\Models\User;
use App\Observers\UserObserver;
use App\Repositories\UserRepositoryRepository;
use App\Repositories\UserRepositoryRepositoryEloquent;
use Illuminate\Support\ServiceProvider;
use Laravel\Passport\AuthCode;
use Laravel\Passport\Client;
use Laravel\Passport\Passport;
use Laravel\Passport\PersonalAccessClient;
use Laravel\Passport\RefreshToken;
use Laravel\Passport\Token;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Passport::useTokenModel(Token::class);

        Passport::useRefreshTokenModel(RefreshToken::class);

        Passport::useAuthCodeModel(AuthCode::class);

        Passport::useClientModel(Client::class);

        Passport::usePersonalAccessClientModel(PersonalAccessClient::class);
        User::observe(UserObserver::class);
        $this->app->bind(UserRepositoryRepository::class, UserRepositoryRepositoryEloquent::class);
        //
    }
}
