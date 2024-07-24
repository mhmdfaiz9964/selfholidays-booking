<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Supplement extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'hotel_id',
    ];

    // Relationships
    public function hotel()
    {
        return $this->belongsTo(Hotel::class, 'hotel_id');
    }

    public function pricings()
    {
        return $this->belongsToMany(Pricing::class, 'pricing_has_supplements', 'supplements_id', 'pricings_id')
                    ->withPivot('supplements_start_date', 'supplements_end_date', 'supplements_price');
    }
}
