<?php

namespace App\Providers;

use App\Models\User;
use App\Observers\UserObserver;
use App\Repositories\UserRepositoryRepository;
use App\Repositories\UserRepositoryRepositoryEloquent;
use App\Repository\BookDetailRepository;
use App\Repository\BookingDetailRepository;
use App\Repository\BookingRepository;
use App\Repository\BookRepository;
use App\Service\BookingService;
use App\Service\BookService;
use App\Service\IbookingService;
use App\Service\IbookService;
use Illuminate\Support\ServiceProvider;
use Laravel\Passport\AuthCode;
use Laravel\Passport\Client;
use Laravel\Passport\Passport;
use Laravel\Passport\PersonalAccessClient;
use Laravel\Passport\RefreshToken;
use Laravel\Passport\Token;
use Prettus\Repository\Eloquent\BaseRepository;

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
        $this->app->singleton(BookRepository::class, function () {
            return new BookRepository();
        });
        $this->app->singleton(BookingRepository::class, function () {
            return new BookingRepository();
        });
        $this->app->singleton(BookDetailRepository::class, function () {
            return new BookDetailRepository();
        });
        $this->app->bind(IbookService::class, BookService::class);
        $this->app->bind(IbookingService::class, BookingService::class);
        $this->app->singleton(BookingDetailRepository::class, function () {
            return new BookingDetailRepository();
        });

    }
}
