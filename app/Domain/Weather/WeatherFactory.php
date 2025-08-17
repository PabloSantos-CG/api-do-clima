<?php

namespace App\Domain\Weather;

class WeatherFactory
{
    /** 
     * @param string[] $coordinates 
     */
    public function make(array $coordinates): WeatherInterface
    {
        return new VisualCrossingWeather($coordinates);
    }
}
