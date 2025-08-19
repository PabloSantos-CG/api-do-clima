<?php

namespace App\Http\Controllers;

use App\Domain\Services\WeatherService;
use Illuminate\Http\Request;

class WeatherController extends Controller
{
    public function __construct(
        private WeatherService $weatherService,
    ) {}

    public function getAllData(Request $request)
    {
        $apiKey = $request->input('api_key');
        $coordinates = $request->input('coordinates');

        if (!$apiKey) {
            return \response()->json([
                'status' => 'error',
                'message' => 'api_key property not found',
            ], 400);
        }

        if (!$coordinates || \count($coordinates) != 2) {
            return \response()->json([
                'status' => 'error',
                'message' => 'coordinate property not found',
            ], 400);
        }

        $response = $this->weatherService->fetchAllCurrentWeatherData(
            $apiKey,
            $coordinates
        );

        if (!$response->successful()) {
            return \response()->json([
                'status' => 'error',
                'message' => 'api indisponível',
            ], 400);
        }

        return \response()->json(
            $response->json(),
            $response->status()
        );
    }
}
