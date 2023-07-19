<?php

namespace Database\Seeders;

use App\Repositories\Interfaces\CapacityRepositoryInterface;
use Illuminate\Database\Seeder;

class CapacitySeeder extends Seeder
{
    public function __construct(
        private readonly CapacityRepositoryInterface $capacityRepository
    ) {}

    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $csvCapacityData = fopen(database_path('seeders/imports/capacity.csv'), 'r');
        $transRow = true;
        while (($data = fgetcsv($csvCapacityData, 555, ',')) !== false)
        {
            if (!$transRow)
            {
                $isDateExists = $this->capacityRepository->findByHotelIdAndDate($data[0], $data[1]);
                if ($isDateExists)
                {
                    $updatedCapacity = $isDateExists->capacity + $data[2];
                    $this->capacityRepository->updateCapacity($isDateExists->id, $updatedCapacity);
                    continue;
                }
                $new = [
                    'hotel_id' => $data['0'],
                    'date' => $data['1'],
                    'capacity' => $data['2'],
                ];
                $this->capacityRepository->create($new);
            }
            $transRow = false;
        }
        fclose($csvCapacityData);
    }
}
