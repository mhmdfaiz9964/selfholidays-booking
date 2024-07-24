<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Booking extends Model
{
    use HasFactory;

    protected $fillable = [
        'hotel_id',
        'full_name',
        'email',
        'phone',
        'room_type_id',
        'number_of_children',
        'number_of_adults',
        'supplements',
        'meals',
        'checkin_date',
        'checkout_date',
        'price',
        'message',
    ];

    protected $casts = [
        'supplements' => 'array',
        'meals' => 'array',
    ];

    /**
     * Get the hotel associated with the booking.
     */
    public function hotel()
    {
        return $this->belongsTo(Hotel::class);
    }

    /**
     * Get the room category associated with the booking.
     */
    public function roomCategory()
    {
        return $this->belongsTo(RoomCategory::class, 'room_type_id');
    }
}
