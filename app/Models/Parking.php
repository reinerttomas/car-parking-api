<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Parking extends Model
{
    use HasFactory;

    protected $fillable  = ['user_id', 'vehicle_id', 'zone_id', 'start_at', 'stop_at', 'total_price'];

    protected $casts = [
        'start_at' => 'datetime',
        'stop_at' => 'datetime',
    ];
}
