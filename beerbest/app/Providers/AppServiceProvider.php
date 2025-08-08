<?php

namespace App\Providers;

use App\Infrastructure\Repository\Cache\CacheImplementationDecorator;
use App\Infrastructure\Repository\Eloquent\EloquentImplementation;
use App\Infrastructure\Repository\GeoLocationRepositoryInterface;
use App\Infrastructure\Repository\MongoDB\MongoDBImplementation;
use App\Infrastructure\Repository\RepositoryInterface;
use App\Service\BeerService;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Support\ServiceProvider;
use MongoDB\Client;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->singleton(Client::class, function () {
            $dsn = env('MONGODB_PROTOCOL');
            $dsn .= env('MONGODB_USER') . ':' . env('MONGODB_PASSWORD');
            $dsn .= '@' . env('MONGODB_HOST') . ':' . env('MONGODB_PORT');
            return new Client($dsn);
        });

        $this->app->singleton(MongoDBImplementation::class, function (Application $app) {
            $client = $app->get(Client::class);
            $database = $client->selectDatabase(env('MONGODB_DATABASE'));
            $mongoDBImplementation = new MongoDBImplementation($database);
            $mongoDBImplementation->setCollectionName('locations');
            return $mongoDBImplementation;
        });

        $this->app->singleton(EloquentImplementation::class, function () {
            $eloquentImplementation = new EloquentImplementation();
            $eloquentImplementation->setCollectionName('beers');
            return $eloquentImplementation;
        });

        $this->app->singleton(GeoLocationRepositoryInterface::class, function (Application $app) {
            return $app->get(MongoDBImplementation::class);
        });

        $this->app->singleton(BeerService::class, function (Application $app) {
            $cacheProxy = new CacheImplementationDecorator(
                $app->get(GeoLocationRepositoryInterface::class)
            );

            return new BeerService($cacheProxy);
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
