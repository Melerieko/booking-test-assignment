<?php

namespace App\Repositories;

use App\Models\Booking;
use App\Repositories\Interfaces\BookingRepositoryInterface;
use Illuminate\Support\Collection;

class BookingRepository implements BookingRepositoryInterface
{
    public function getByHotelId(int $hotelId): Collection
    {
        return Booking::query()
            ->where('hotel_id', '=', $hotelId)
            ->orderBy('purchase_day')
            ->orderBy('id')
            ->get();
    }

    public function getAllRejected(): Collection
    {
        return Booking::query()
            ->where('status', '=', Booking::STATUS_REJECTED)
            ->orderBy('arrival_date')
            ->get();
    }

    public function getApprovedByHotelId(int $hotelId): Collection
    {
        return Booking::query()
            ->where('hotel_id', '=', $hotelId)
            ->where('status', '=', Booking::STATUS_APPROVED)
            ->get();
    }

    public function getRejectedByHotelId(int $hotelId): Collection
    {
        return Booking::query()
            ->where('hotel_id', '=', $hotelId)
            ->where('status', '=', Booking::STATUS_REJECTED)
            ->get();
    }

    public function create(array $data)
    {
        return Booking::query()
            ->insert([
                'hotel_id' => $data['hotel_id'],
                'customer_id' => $data['customer_id'],
                'sales_price' => $data['sales_price'],
                'purchase_price' => $data['purchase_price'],
                'arrival_date' => $data['arrival_date'],
                'purchase_day' => $data['purchase_day'],
                'nights' => $data['nights'],
            ]);
    }

    public function updateStatus(int $bookingId, int $status): int
    {
        return Booking::query()
            ->where('id', '=', $bookingId)
            ->update(['status' => $status]);
    }
}
