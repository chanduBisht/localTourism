<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Hotels extends Model
{
    use HasFactory;

    protected $table = 'hotels';

    protected $fillable = [
        'user_id',
        'place_id',
        'name',
        'description',
        'facility',
        'location',
        'check_in',
        'check_out',
        'image',
        'status'
    ];

    public function place()
    {
        return $this->belongsTo(Places::class, 'place_id');
    }
}
