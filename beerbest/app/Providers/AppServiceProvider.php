<?php

namespace App\Providers;

use App\Infrastructure\Repository\Eloquent\EloquentImplementation;
use App\Infrastructure\Repository\GeoLocationRepositoryInterface;
use App\Service\BeerService;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->singleton(BeerService::class, function ($app) {
            $beerRepository = new EloquentImplementation();
            $beerRepository->setCollectionName("beers");
            return new BeerService($beerRepository);
        });
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}
