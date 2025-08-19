<?php

namespace App\Domain\Weather;

class WeatherFactory
{
    /** 
     * @param string[] $coordinates 
     */
    public function make(array $coordinates): VisualCrossingWeather
    {
        return new VisualCrossingWeather($coordinates);
    }
}
