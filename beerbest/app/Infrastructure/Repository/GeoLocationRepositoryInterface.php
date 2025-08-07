<?php

namespace App\Infrastructure\Repository;

interface GeoLocationRepositoryInterface
{
    /**
     * @param string $userLongitude
     * @param string $userLatitude
     * @param int $userRadiusDistance
     * @return array<object>
     */
    public function getByGeoLocation(string $userLongitude, string $userLatitude, int $userRadiusDistance): array;
}
