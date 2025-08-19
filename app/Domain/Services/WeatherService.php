<?php

namespace App\Domain\Services;

use App\Domain\Weather\WeatherFactory;
use App\Utils\TimeFormatter;
use CacheRepositoryInterface;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Http;

class WeatherService
{
    public function __construct(
        private WeatherFactory $weatherFactory,
        private CacheRepositoryInterface $cacheRepository,
    ) {}

    /** 
     * @param string[] $coordinates 
     */
    public function fetchAllCurrentWeatherData(
        string $apiKey,
        array $coordinates
    ): mixed {
        $jsonDataCache = $this->cacheRepository->getKey("$apiKey:data");

        if ($jsonDataCache) {
            $rateLimit = (int) $this->cacheRepository->getKey("$apiKey:rate_limit");

            if ($rateLimit >= 60) {
                $ttl = $this->cacheRepository->getTtl($apiKey);
                $time = TimeFormatter::formatTtl($ttl);
                
                return [
                    'rateLimit' => "rate limit reached, service unavailable for $time"
                ];
            }

            $this->cacheRepository->incrementRateLimit($apiKey);
            return $jsonDataCache;
        }

        $url = $this->weatherFactory->make($coordinates)->getUrlForAllData();
        $response = Http::get($url);

        if (!$response->successful()) return null;

        $this->cacheRepository->setKey("$apiKey:data", $response->json(), 3600);
        $this->cacheRepository->setKey("$apiKey:rate_limit", 0, 86400);

        return $response->json();
    }
}
