<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pricing extends Model
{
    use HasFactory;

    protected $fillable = [
        'hotel_id', 'supplements_id', 'meals_id', 'type', 'sgl', 'dbl', 'tpl', 'Quartable', 'Family', 'Start_date', 'End_date' ,'special_offer' ,'supplement_prices',
    ];

    protected $casts = [
        'supplements_id' => 'array',
        'meals_id' => 'array',
        'supplement_prices' => 'array',
    ];

    public function hotel()
    {
        return $this->belongsTo(Hotel::class);
    }

    public function meals()
    {
        return $this->belongsToMany(Meal::class, 'meal_pricing', 'pricing_id', 'meal_id');
    }

    public function supplements()
    {
        return $this->belongsToMany(Supplement::class, 'supplement_pricing', 'pricing_id', 'supplement_id');
    }
}
