<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RoomPricing extends Model
{
    use HasFactory;

    protected $table = 'room_pricing';

    protected $fillable = [
        'hotel_id',
        'room_category_id',
        'room_only_price',
        'room_only_start_date',
        'room_only_end_date',
        'bed_and_breakfast_price',
        'bed_and_breakfast_start_date',
        'bed_and_breakfast_end_date',
        'half_board_price',
        'half_board_start_date',
        'half_board_end_date',
        'full_board_price',
        'full_board_start_date',
        'full_board_end_date',
        'all_inclusive_price',
        'all_inclusive_start_date',
        'all_inclusive_end_date',
    ];

    // Relationships
    public function hotel()
    {
        return $this->belongsTo(Hotel::class, 'hotel_id');
    }

    public function roomCategory()
    {
        return $this->belongsTo(RoomCategory::class, 'room_category_id');
    }
}
