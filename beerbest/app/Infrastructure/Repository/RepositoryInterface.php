<?php

namespace App\Infrastructure\Repository;

interface RepositoryInterface
{
    public function setCollectionName(string $collectionName): void;
}
