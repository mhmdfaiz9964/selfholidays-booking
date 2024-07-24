<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PricingHasSupplements extends Model
{
    use HasFactory;

    protected $fillable = [
        'supplements_id',
        'pricings_id',
        'supplements_start_date',
        'supplements_end_date',
        'supplements_price',
    ];

    // Relationships
    public function supplement()
    {
        return $this->belongsTo(Supplement::class, 'supplements_id');
    }

    public function pricing()
    {
        return $this->belongsTo(Pricing::class, 'pricings_id');
    }
    
}