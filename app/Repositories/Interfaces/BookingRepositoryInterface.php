<?php

namespace App\Repositories\Interfaces;

interface BookingRepositoryInterface
{
    public function getByHotelId(int $hotelId);
    public function getAllRejected();
    public function getApprovedByHotelId(int $hotelId);
    public function getRejectedByHotelId(int $hotelId);
    public function create(array $data);
    public function updateStatus(int $bookingId, int $status);
}
