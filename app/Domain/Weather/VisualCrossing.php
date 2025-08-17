<?php

class VisualCrossing implements WeatherInterface
{
    private string $timezone;

    /**
     *  @param string[] $location
     */
    public function __construct(
        private array $location,
        private string | null $secret_key_access = null,
        private string $unitGroup = 'metric',
        private string $baseUrl = "https://weather.visualcrossing.com/VisualCrossingWebServices/rest/services/timeline/",
    ) {
        $this->timezone = 'Z';
        $this->secret_key_access??= env('WEATHER_API_SECRET_ACCESS_KEY');
    }

    private function buildBaseUrl(): string {
        $url = $this->baseUrl;
        $url .= $this->location[0] . ',' . $this->location[1] . '/';
        $url .= date('d-m-Y\TH:m:s') . '/' . '?timezone=' . $this->timezone;
        $url .= '&key=' . $this->secret_key_access;

        return $url;
    }

    public function getApiUrl(): string
    {
        $baseUrl = $this->buildBaseUrl();
        $baseUrl .= '&unitGroup=' . $this->unitGroup;
        $baseUrl .= '&include=alerts,current,stats';

        return $baseUrl;
    }
}