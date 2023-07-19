<?php

namespace App\Services;

use Carbon\Carbon;
use Carbon\CarbonPeriod;

class BookedDatesService
{
    public static function getPeriod($booking): array
    {
        $arrivalDate = Carbon::parse($booking->arrival_date);
        $lastDate = $arrivalDate->copy()->addDays($booking->nights - 1);

        return array_map(function ($element) {
            return $element->format('Y-m-d');
        }, CarbonPeriod::create($arrivalDate, $lastDate)->toArray());
    }
}
