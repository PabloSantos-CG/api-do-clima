<?php

namespace App\Domain\Services;

use App\Domain\Weather\WeatherFactory;
use CacheRepositoryInterface;
use Illuminate\Support\Facades\Http;

class WeatherService
{
    public function __construct(
        private WeatherFactory $weatherFactory,
        private CacheRepositoryInterface $cacheRepository,
    ) {}

    /** @param string[] $coordinates */
    public function fetchAllCurrentWeatherData(
        string $apiKey,
        array $coordinates
    ) {
        $jsonData = $this->cacheRepository->getKey($apiKey);

        if ($jsonData) {
            
            return $jsonData;
        }


        $url = $this->weatherFactory->make($coordinates)->getUrlForAllData();
        // return Http::get($url);

        $response = Http::get($url);

        $this->cacheRepository->setKey(
            $apiKey,
            $response->json(),
            3600,
        );
        $this->cacheRepository->setKey("$apiKey:request_counter", 0, 86400);
    }
}
