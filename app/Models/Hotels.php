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

    public function hotelHasPricing()
    {
        return $this->hasMany(HotelHasPricing::class, 'hotel_id');
    }

public function supplements()
{
    return $this->belongsToMany(Supplement::class, 'hotel_has_supplement', 'hotel_id', 'supplement_id');
}

    public function pricingHasSupplements()
    {
        return $this->hasMany(PricingHasSupplements::class, 'supplements_id');
    }
    
}
