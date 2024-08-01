<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Booking extends Model
{
    use HasFactory;

    protected $fillable = [
        'hotel_id',
        'meal_ids',
        'supplement_ids',
        'price',
        'full_name',
        'email',
        'mobile',
        'checkin_date',
        'checkout_date',
        'adults',
        'children',
        'notes',
    ];

    protected $casts = [
        'meal_ids' => 'array',
        'supplement_ids' => 'array',
    ];

    // Relationships
    public function hotel()
    {
        return $this->belongsTo(Hotel::class);
    }

    public function meals()
    {
        return $this->belongsToMany(Meal::class, 'meal_ids', 'id', 'meal_id');
    }

    public function supplements()
    {
        return $this->belongsToMany(Supplement::class, 'supplement_ids', 'id', 'supplement_id');
    }
}
