<?php

namespace App\Infrastructure\Repository\Eloquent;

use App\Infrastructure\Repository\GeoLocationRepositoryInterface;
use App\Infrastructure\Repository\RepositoryInterface;
use Illuminate\Support\Str;

class EloquentImplementation implements RepositoryInterface, GeoLocationRepositoryInterface
{
    protected string $collectionName;

    public function getByGeoLocation(string $userLongitude, string $userLatitude, int $userRadiusDistance): array
    {
        $modelName = Str::singular(Str::studly($this->collectionName)); // nome_tests -> NomeTest

        $modelString = '\App\Models\\' . $modelName;

        if (false === class_exists($modelString)) {
            throw new \Exception('Model class does not exist');
        }

        $model = new $modelString();

        $join = $model
                    ->join('locations as l', 'l.beer_id', '=', 'beers.id')
                    ->select(
                        'beers.name',
                        'beers.type',
                        'beers.price',
                        'l.longitude',
                        'l.latitude'
                    );

        return $join->whereRaw("
            6371 * 2 * ASIN(
                SQRT(
                    POW(SIN((RADIANS(?) - RADIANS(l.latitude)) / 2), 2) +
                    COS(RADIANS(?)) * COS(RADIANS(l.latitude)) *
                    POW(SIN((RADIANS(?) - RADIANS(l.longitude)) / 2), 2)
                )
            ) <= ?
        ", [$userLatitude, $userLatitude, $userLongitude, $userRadiusDistance / 1000])
        ->get()
        ->toArray();
    }

    public function setCollectionName(string $collectionName): void
    {
        $this->collectionName = $collectionName;
    }
}
