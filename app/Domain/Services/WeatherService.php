<?php

namespace App\Domain\Services;

use App\Domain\Weather\WeatherFactory;
use App\Infrastructure\CacheRepositoryInterface;
use App\Utils\TimeFormatter;

use Illuminate\Support\Facades\Http;

class WeatherService
{
    public function __construct(
        private WeatherFactory $weatherFactory,
        private CacheRepositoryInterface $cacheRepository,
    ) {}

    /** 
     * @return array<string, mixed> | null
     */
    private function getJsonDataInCache(string $apiKey): mixed
    {
        $jsonDataCache = \json_decode(
            $this->cacheRepository->getKey("$apiKey:data"),
            \true
        );

        if ($jsonDataCache) {
            $rateLimit = (int) $this->cacheRepository->getKey("$apiKey:rate_limit");

            if ($rateLimit >= 60) {
                $ttl = $this->cacheRepository->getTtl($apiKey);
                $time = TimeFormatter::formatTtl($ttl);

                return [
                    'rateLimit' => "rate limit reached, service unavailable for $time"
                ];
            }

            $this->cacheRepository->incrementRateLimit("$apiKey:rate_limit");
            return $jsonDataCache;
        }

        return null;
    }

    /** 
     * @param string[] $coordinates 
     * @return array<string, mixed> | null
     */
    public function fetchAllCurrentWeatherData(
        string $apiKey,
        array $coordinates
    ): mixed {
        $jsonDataCache = $this->getJsonDataInCache($apiKey);
        if ($jsonDataCache) return $jsonDataCache;

        $url = $this->weatherFactory->make($coordinates)->getUrlForAllData();
        $response = Http::get($url);

        if (!$response->successful()) return null;

        $jsonData = \json_encode($response->json());

        $this->cacheRepository->setKey("$apiKey:data", $jsonData, 3600);
        $this->cacheRepository->setKey("$apiKey:rate_limit", 0, 86400);

        return $response->json();
    }
}
