<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class HotelHasPricing extends Model
{
    use HasFactory;

    protected $fillable = [
        'pricings_id',
        'hotel_id',
        'start_date',
        'end_date',
    ];

    // Relationships
    public function pricing()
    {
        return $this->belongsTo(Pricing::class, 'pricings_id');
    }

    public function hotel()
    {
        return $this->belongsTo(Hotel::class, 'hotel_id');
    }
}