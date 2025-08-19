<?php

namespace App\Utils;

class TimeFormatter
{
    public static function formatTtl(string $ttl): string
    {
        $hours = floor($ttl / 3600);
        $minutes = floor(($ttl % 3600) / 60);
        return sprintf("%02d:%02d", $hours, $minutes);
    }
}
