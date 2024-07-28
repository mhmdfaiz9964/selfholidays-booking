<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Meal extends Model
{
    use HasFactory;

    protected $fillable = ['title', 'hotel_id'];

    public function hotel()
    {
        return $this->belongsTo(Hotel::class);
    }

    public function pricings()
    {
        return $this->belongsToMany(Pricing::class, 'meal_pricing', 'meal_id', 'pricing_id');
    }
}
