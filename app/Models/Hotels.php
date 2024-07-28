<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Hotels extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'rating',
        'location_id',
        'description',
        'image',
        'group_of_company',
        'sales_manager_name',
        'sales_manager_contact',
        'room_category_id',
        'email',
        'phone',
        'pdf_urls',
    ];

    protected $casts = [
        'pdf_urls' => 'array',
    ];

    // Relationships
    public function location()
    {
        return $this->belongsTo(Location::class);
    }

    public function roomCategory()
    {
        return $this->belongsTo(RoomCategory::class);
    }

    public function roomCategories()
    {
        return $this->belongsToMany(RoomCategory::class, 'hotel_room_category', 'hotel_id', 'room_category_id');
    }

    public function meals()
    {
        return $this->hasMany(Meal::class, 'hotel_id');
    }

    public function supplements()
    {
        return $this->hasMany(Supplement::class, 'hotel_id');
    }

    public function pricings()
    {
        return $this->hasMany(Pricing::class, 'hotel_id');
    }
}
