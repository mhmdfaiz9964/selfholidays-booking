<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pricing extends Model
{
    use HasFactory;

    protected $fillable = [
        'room_category_id',
        'meal',
        'sgl',
        'dbl',
        'tpl',
        'quartable',
        'family',
    ];

    // Relationships
    public function roomCategory()
    {
        return $this->belongsTo(RoomCategory::class, 'room_category_id');
    }

    public function hotels()
    {
        return $this->hasMany(HotelHasPricing::class, 'pricings_id');
    }

    public function supplements()
    {
        return $this->belongsToMany(Supplement::class, 'pricing_has_supplements', 'pricings_id', 'supplements_id')
                    ->withPivot('supplements_start_date', 'supplements_end_date', 'supplements_price');
    }
}