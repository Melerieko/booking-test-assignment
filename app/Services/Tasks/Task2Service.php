<?php

namespace App\Services\Tasks;

use App\Repositories\Interfaces\BookingRepositoryInterface;
use App\Repositories\Interfaces\CapacityRepositoryInterface;
use App\Repositories\Interfaces\HotelRepositoryInterface;
use App\Services\BookedDatesService;
use Carbon\Carbon;

/**
 * Service for Task 2.
 *
 * Service returns list of hotels and dates where we had to reject customers.
 */
class Task2Service implements TaskInterface
{
    private array $statistic;

    public function __construct(
        private readonly HotelRepositoryInterface    $hotelRepository,
        private readonly CapacityRepositoryInterface $capacityRepository,
        private readonly BookingRepositoryInterface  $bookingRepository,
    ) {}

    public function calculate(): array
    {
        $hotels = $this->hotelRepository->getAll();
        foreach ($hotels as $hotel)
        {
            $datesWithRejects = [];

            $rejectedBookings = $this->bookingRepository->getRejectedByHotelId($hotel->id);
            foreach ($rejectedBookings as $rejectedBooking)
            {
                $arrivalDate = Carbon::parse($rejectedBooking->arrival_date);
                $lastDate = $arrivalDate->copy()->addDays($rejectedBooking->nights - 1);

                $bookedDates = BookedDatesService::getPeriod($rejectedBooking);

                $dateWithEmptyCapacity = $this->capacityRepository->getByHotelIdAndDateRangeWithEmptyCapacity(
                    $rejectedBooking->hotel_id,
                    $arrivalDate,
                    $lastDate
                );

                if (!$dateWithEmptyCapacity)
                {
                    $datesWithNonEmptyCapacity = [];
                    $capacityPerHotel = $this->capacityRepository->getByHotelIdAndDateRangeWithNonEmptyCapacity(
                        $rejectedBooking->hotel_id,
                        $arrivalDate,
                        $lastDate
                    );

                    foreach ($capacityPerHotel as $capacity)
                    {
                        $datesWithNonEmptyCapacity[] = $capacity->date;
                    }
                    $datesWithRejects[] = array_values(array_diff($bookedDates, $datesWithNonEmptyCapacity))[0];
                    continue;
                }
                $datesWithRejects[] = $dateWithEmptyCapacity->date;
            }

            if (empty($datesWithRejects))
            {
                continue;
            }

            sort($datesWithRejects);
            $this->statistic[] = [
                'id' => $hotel->id,
                'name' => $hotel->name,
                'dates' => array_unique($datesWithRejects)
            ];
        }
        return $this->statistic;
    }
}
