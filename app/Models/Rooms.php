<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Rooms extends Model
{
    use HasFactory;

    protected $table = 'rooms';

    protected $fillable = [
        'user_id',
        'hotel_id',
        'name',
        'room_price',
        'room_availability',
        'room_description',
        'image',
        'status'
    ];

    public function hotel()
    {
        return $this->belongsTo(Hotels::class, 'hotel_id');
    }
}
