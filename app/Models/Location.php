<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Location extends Model
{
    use HasFactory;

    protected $fillable = [
        'district_id',
        'province_id',
        'name',
        'sinhala_name',
        'tamil_name',
    ];
}
