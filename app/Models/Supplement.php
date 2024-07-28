<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Supplement extends Model
{
    use HasFactory;

    protected $fillable = ['title', 'hotel_id'];

    public function hotel()
    {
        return $this->belongsTo(Hotel::class);
    }

    public function pricings()
    {
        return $this->belongsToMany(Pricing::class, 'supplement_pricing', 'supplement_id', 'pricing_id');
    }
}
