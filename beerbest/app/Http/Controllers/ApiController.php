<?php

namespace App\Http\Controllers;

use App\Models\Beer;
use App\Models\Location;
use App\Service\BeerService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ApiController extends Controller
{
    public function __construct(
        protected BeerService $beerService,
    ) {
    }
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string',
            'type' => 'required|string',
            'price' => 'required|decimal:2',
            'longitude' => 'required|numeric|between:-180,180',
            'latitude' => 'required|numeric|between:-90,90',
        ]);

        // Adicionar na camada: DataAccess/Infra/Repository
        $beer = new Beer([
            'name' => $request->get('name'),
            'type' => $request->get('type'),
            'price' => $request->get('price')
        ]);

        $beer->save();

        $location = new Location([
            'beer_id' => $beer->id,
            'longitude' => $request->get('longitude'),
            'latitude' => $request->get('latitude')
        ]);

        $location->save();

        return response()->json([
            'message' => 'Successfully created beer!'
        ], 201);
    }

    public function search(Request $request): array
    {
        $request->validate([
            'longitude' => 'required|numeric|between:-180,180',
            'latitude' => 'required|numeric|between:-90,90',
            'distance' => 'required|numeric',
        ]);

        $userLongitude = $request->input('longitude');
        $userLatitude = $request->input('latitude');
        $userRadiusDistance = $request->input('distance');

        // Adicionar na camada: DataAccess/Infra/Repository
        // Pode virar um DTO
        $results = $this->beerService->search($userLongitude, $userLatitude, $userRadiusDistance);

        // Adicionar Presenter para saída padrão
        return [
            'data' => $results
        ];
    }
}
