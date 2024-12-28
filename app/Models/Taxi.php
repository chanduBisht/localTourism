<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Taxi extends Model
{
    use HasFactory;

    protected $table = 'taxis';

    protected $fillable = [
        'user_id',
        'place_id',
        'name',
        'car_number',
        'car_price',
        'car_availability',
        'car_description',
        'image',
        'status'
    ];

    public function place()
    {
        return $this->belongsTo(Places::class, 'place_id');
    }
}
