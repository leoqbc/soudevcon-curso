<?php

namespace App\Http\Controllers;

use App\Models\Beer;
use App\Models\Location;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ApiController extends Controller
{
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

        $longitude = $request->input('longitude');
        $latitude = $request->input('latitude');
        $distance = $request->input('distance');

        // Adicionar na camada: DataAccess/Infra/Repository
        $results = DB::table('locations as l')
            ->join('beers as b', 'b.id', '=', 'l.beer_id')
            ->select(
                'b.name',
                'b.type',
                'b.price',
                'l.longitude',
                'l.latitude'
            )->whereRaw("
                6371 * 2 * ASIN(
                    SQRT(
                        POW(SIN((RADIANS(?) - RADIANS(l.latitude)) / 2), 2) +
                        COS(RADIANS(?)) * COS(RADIANS(l.latitude)) *
                        POW(SIN((RADIANS(?) - RADIANS(l.longitude)) / 2), 2)
                    )
                ) <= ?
            ", [$latitude, $latitude, $longitude, $distance / 1000])
            ->get();

        // Adicionar Presenter para saída padrão
        return [
            'data' => $results
        ];
    }
}
