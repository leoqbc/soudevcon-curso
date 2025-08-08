<?php

namespace App\Infrastructure\Repository\MongoDB;

use App\Infrastructure\Repository\GeoLocationRepositoryInterface;
use App\Infrastructure\Repository\RepositoryInterface;
use MongoDB\Database;

class MongoDBImplementation implements RepositoryInterface, GeoLocationRepositoryInterface
{
    protected string $collectionName;

    public function __construct(
        protected Database $database,
    ) {
    }


    /**
     * @param string $userLongitude
     * @param string $userLatitude
     * @param int $userRadiusDistance
     * @return array[]
     */
    public function getByGeoLocation(string $userLongitude, string $userLatitude, int $userRadiusDistance): array
    {
        $geometrySearch = [
            '$geometry' => [
                'coordinates' => [
                    (float)$userLongitude,
                    (float)$userLatitude
                ],
                'type' => 'Point'
            ],
            '$maxDistance' => $userRadiusDistance
        ];

        $collection = $this->database->getCollection($this->collectionName);

        // Implentação de busca por geolocalização
        $result = $collection->find([
           'geometry' => [
               '$nearSphere' => $geometrySearch
           ]
        ], [ 'projection' => ['_id' => 0] ]);

        // tenha cuidado com o tamanho dos registros
        return $result->toArray();
    }

    public function setCollectionName(string $collectionName): void
    {
        // validação se collection existe
        $this->collectionName = $collectionName;
    }
}
