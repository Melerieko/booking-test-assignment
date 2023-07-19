<?php

namespace Database\Seeders;

use App\Repositories\Interfaces\BookingRepositoryInterface;
use Illuminate\Database\Seeder;

class BookingSeeder extends Seeder
{
    public function __construct(
        private readonly BookingRepositoryInterface $bookingRepository
    ) {}

    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $csvBookingData = fopen(database_path('seeders/imports/bookings.csv'), 'r');
        $transRow = true;
        while (($data = fgetcsv($csvBookingData, 555, ',')) !== false) {
            if (!$transRow) {
                $new = [
                    'hotel_id' => $data['1'],
                    'customer_id' => $data['2'],
                    'sales_price' => $data['3'],
                    'purchase_price' => $data['4'],
                    'arrival_date' => $data['5'],
                    'purchase_day' => $data['6'],
                    'nights' => $data['7'],
                ];
                $this->bookingRepository->create($new);
            }
            $transRow = false;
        }
        fclose($csvBookingData);
    }
}
