<?php

namespace App\Repositories;

use App\Models\Capacity;
use App\Repositories\Interfaces\CapacityRepositoryInterface;

class CapacityRepository implements CapacityRepositoryInterface
{
    public function findByHotelIdAndDate(int $hotelId, string $date)
    {
        return Capacity::query()
            ->where('hotel_id', '=', $hotelId)
            ->where('date', '=', $date)
            ->first();
    }
    public function getByHotelIdAndDateRangeWithNonEmptyCapacity(int $hotelId, string $arrivalDate, string $lastDate)
    {
        return Capacity::query()
            ->where('hotel_id', '=', $hotelId)
            ->whereBetween('date', [$arrivalDate, $lastDate])
            ->where('capacity', '>', 0)
            ->get();
    }

    public function getByHotelIdAndDateRangeWithEmptyCapacity(int $hotelId, string $arrivalDate, string $lastDate)
    {
        return Capacity::query()
            ->where('hotel_id', '=', $hotelId)
            ->whereBetween('date', [$arrivalDate, $lastDate])
            ->where('capacity', '=', 0)
            ->first();
    }

    public function create(array $data)
    {
        return Capacity::query()
            ->insert([
                'hotel_id' => $data['hotel_id'],
                'date' => $data['date'],
                'capacity' => $data['capacity'],
            ]);
    }

    public function updateCapacity(int $id, int $newCapacity)
    {
        return Capacity::query()
            ->where('id', '=', $id)
            ->update(['capacity' => $newCapacity]);
    }
}
