<?php

namespace App\Console\Commands;

use App\Models\Booking;
use App\Repositories\Interfaces\BookingRepositoryInterface;
use App\Repositories\Interfaces\CapacityRepositoryInterface;
use App\Repositories\Interfaces\HotelRepositoryInterface;
use Carbon\Carbon;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

class SetBookingStatuses extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'booking:set-statuses';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Set statuses to bookings';

    public function __construct(
        private readonly HotelRepositoryInterface    $hotelRepository,
        private readonly CapacityRepositoryInterface $capacityRepository,
        private readonly BookingRepositoryInterface  $bookingRepository,
    ) {
        parent::__construct();
    }

    /**
     * Execute the console command.
     */
    public function handle(): void
    {
        $this->info('Status setting in progress. Wait...' . "\n");

        DB::beginTransaction();

        $hotels = $this->hotelRepository->getAll();
        foreach ($hotels as $hotel)
        {
            $bookingsPerHotel = $this->bookingRepository->getByHotelId($hotel->id);
            foreach ($bookingsPerHotel as $booking)
            {
                $arrivalDate = Carbon::parse($booking->arrival_date);
                $lastDate = $arrivalDate->copy()->addDays($booking->nights - 1);

                $capacityPerDates = $this->capacityRepository->getByHotelIdAndDateRangeWithNonEmptyCapacity(
                    $hotel->id,
                    $arrivalDate,
                    $lastDate
                );

                if (count($capacityPerDates) === $booking->nights)
                {
                    $this->bookingRepository->updateStatus($booking->id, Booking::STATUS_APPROVED);
                    foreach ($capacityPerDates as $capacityPerDate)
                    {
                        $this->capacityRepository->updateCapacity(
                            $capacityPerDate->id,
                            $capacityPerDate->capacity - 1
                        );
                    }
                    continue;
                }
                $this->bookingRepository->updateStatus($booking->id, Booking::STATUS_REJECTED);
            }
        }

        DB::commit();
        $this->info('The statuses have been successfully set!');
    }
}
