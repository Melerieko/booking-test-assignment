<?php

namespace App\Services\Tasks;

use App\Repositories\Interfaces\BookingRepositoryInterface;
use App\Repositories\Interfaces\CapacityRepositoryInterface;
use Carbon\Carbon;

/**
 * Service for Task 3.
 *
 * Service returns the day and loss, when we lost the most due to rejection.
 */
class Task3Service implements TaskInterface
{
    public array $statistic;

    public function __construct(
        private readonly CapacityRepositoryInterface $capacityRepository,
        private readonly BookingRepositoryInterface  $bookingRepository,
    ) {}

    public function calculate(): array
    {
        $rejectedBookings = $this->bookingRepository->getAllRejected();

        $lossPerDate = [];

        foreach ($rejectedBookings as $rejectedBooking)
        {
            $arrivalDate = Carbon::parse($rejectedBooking->arrival_date);
            $lastDate = $arrivalDate->copy()->addDays($rejectedBooking->nights - 1);

            $dateWithEmptyCapacity = $this->capacityRepository->getByHotelIdAndDateRangeWithEmptyCapacity(
                $rejectedBooking->hotel_id,
                $arrivalDate,
                $lastDate
            );

            if (!$dateWithEmptyCapacity)
            {
                continue;
            }

            if (!array_key_exists($dateWithEmptyCapacity->date, $lossPerDate))
            {
                $lossPerDate[$dateWithEmptyCapacity->date] = $rejectedBooking->purchase_price;
            } else {
                $lossPerDate[$dateWithEmptyCapacity->date] += $rejectedBooking->purchase_price;
            }
        }

        $maxLoss = max($lossPerDate);
        $date = array_search($maxLoss, $lossPerDate);

        $this->statistic = [
            'date' => $date,
            'value' => $maxLoss,
        ];
        return $this->statistic;
    }
}
