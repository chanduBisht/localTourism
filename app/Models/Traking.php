<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Traking extends Model
{
    use HasFactory;

    protected $table = 'trakings';

    protected $fillable = [
        'user_id',
        'place_id',
        'name',
        'track_km',
        'track_price',
        'track_start_time',
        'track_days',
        'track_availability',
        'track_description',
        'image',
        'status'
    ];

    public function place()
    {
        return $this->belongsTo(Places::class, 'place_id');
    }
}
