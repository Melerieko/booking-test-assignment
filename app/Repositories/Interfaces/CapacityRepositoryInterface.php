<?php

namespace App\Repositories\Interfaces;

interface CapacityRepositoryInterface
{
    public function findByHotelIdAndDate(int $hotelId, string $date);
    public function getByHotelIdAndDateRangeWithNonEmptyCapacity(int $hotelId, string $arrivalDate, string $lastDate);
    public function getByHotelIdAndDateRangeWithEmptyCapacity(int $hotelId, string $arrivalDate, string $lastDate);
    public function create(array $data);
    public function updateCapacity(int $id, int $newCapacity);
}
