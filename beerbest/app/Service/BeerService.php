<?php

namespace App\Service;

// Application
use App\Infrastructure\Repository\RepositoryInterface;
use App\Infrastructure\Repository\GeoLocationRepositoryInterface;

class BeerService
{
    public function __construct(
        // O componente passado aqui deve implementar as duas interfaces
        protected GeoLocationRepositoryInterface $geoLocationRepository,
    ) {
    }

    public function search(string $userLongitude, string $userLatitude, int $userRadiusDistance)
    {
        // Repository específico
        return $this->geoLocationRepository->getByGeoLocation($userLongitude, $userLatitude, $userRadiusDistance);
    }
}
