<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Capacity extends Model
{
    use HasFactory;

    protected $table = 'capacity';
    protected $fillable = [
        'hotel_id',
        'date',
        'capacity'
    ];

    protected $hidden = [
        'created_at',
        'updated_at'
    ];

    public function hotel(): BelongsTo
    {
        return $this->belongsTo(Hotel::class);
    }
}
