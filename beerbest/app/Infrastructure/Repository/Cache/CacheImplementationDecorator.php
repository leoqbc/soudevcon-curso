<?php

namespace App\Infrastructure\Repository\Cache;

use App\Infrastructure\Repository\GeoLocationRepositoryInterface;
use App\Infrastructure\Repository\RepositoryInterface;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Log;

class CacheImplementationDecorator implements GeoLocationRepositoryInterface, RepositoryInterface
{
    public function __construct(
        protected GeoLocationRepositoryInterface & RepositoryInterface $proxiedRepository
    ) {
    }

    public function getByGeoLocation(string $userLongitude, string $userLatitude, int $userRadiusDistance): array
    {
        $key = round($userLongitude, 5) . round($userLatitude, 5);
        $key = str_replace([',', '-', '.'], '', $key);
        Log::info( 'Cached: ' . $key);
        if (Cache::has($key)) {
            return Cache::get($key);
        }
        $result = $this->proxiedRepository->getByGeoLocation($userLongitude, $userLatitude, $userRadiusDistance);
        Cache::set($key, $result, 5000);
        return $result;
    }

    public function setCollectionName(string $collectionName): void
    {
        $this->proxiedRepository->setCollectionName($collectionName);
    }
}
