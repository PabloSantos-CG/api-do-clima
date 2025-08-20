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
        $apiKey = $request->query('api_key');
        $coordinates = [];
        $coordinates[] = $request->query('latitude');
        $coordinates[] = $request->query('longitude');

        // $apiKey = $request->input('api_key');
        // $coordinates = $request->input('coordinates');

        if (!$apiKey) {
            return \response()->json([
                'status' => 'error',
                'message' => 'api_key property not found',
            ], 400);
        }

        if (!$coordinates || \count($coordinates) != 2) {
            return \response()->json([
                'status' => 'error',
                'message' => 'invalid coordinate',
            ], 400);
        }



        $response = $this->weatherService->fetchAllCurrentWeatherData(
            $apiKey,
            $coordinates
        );

        if (!$response) {
            return \response()->json([
                'status' => 'error',
                'message' => 'api indisponível',
            ], 400);
        }

        if (\key_exists('rateLimit', $response)) {
            return \response()->json([
                'status' => 'error',
                'message' => $response['rateLimit'],
            ], 400);
        }

        return \response()->json($response);
    }
}
