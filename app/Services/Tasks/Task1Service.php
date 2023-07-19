<?php

namespace App\Services\Tasks;

use App\Repositories\Interfaces\BookingRepositoryInterface;
use App\Repositories\Interfaces\HotelRepositoryInterface;
use App\Services\BookedDatesService;
use Carbon\Carbon;

/**
 * Service for Task 1.
 *
 * Service returns list of 5 hotels with the smallest number of weekend stays.
 */
class Task1Service implements TaskInterface
{
    private array $statistic;

    public function __construct(
        private readonly HotelRepositoryInterface   $hotelRepository,
        private readonly BookingRepositoryInterface $bookingRepository,
    ){}

    public function calculate(): array
    {
        $hotels = $this->hotelRepository->getAll();
        foreach ($hotels as $hotel)
        {
            $weekendStays = 0;
            $approvedBookings = $this->bookingRepository->getApprovedByHotelId($hotel->id);
            foreach ($approvedBookings as $approvedBooking)
            {
                $bookedDates = BookedDatesService::getPeriod($approvedBooking);
                foreach ($bookedDates as $bookedDate)
                {
                    if(Carbon::parse($bookedDate)->isFriday() || Carbon::parse($bookedDate)->isSaturday())
                    {
                        $weekendStays++;
                    }
                }
            }
            $this->statistic[] = [
                'hotel_id' => $hotel->id,
                'hotel_name' => $hotel->name,
                'weekend_stays' => $weekendStays,
            ];
        }
        usort($this->statistic, function ($first, $second) {
            return $first['weekend_stays'] - $second['weekend_stays'];
        });
        $this->statistic = array_slice($this->statistic, 0, 5);

        return $this->statistic;
    }
}
