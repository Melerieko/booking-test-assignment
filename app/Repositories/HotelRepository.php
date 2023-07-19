<?php

namespace App\Repositories;

use App\Models\Hotel;
use App\Repositories\Interfaces\HotelRepositoryInterface;

class HotelRepository implements HotelRepositoryInterface
{
    public function getAll()
    {
        return Hotel::all();
    }
}
