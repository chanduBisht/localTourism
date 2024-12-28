<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Places extends Model
{
    use HasFactory;

    protected $table = 'places';

    protected $fillable = [
        'name',
        'image'
    ];

    public function hotel()
    {
        return $this->hasMany(Hotels::class, 'place_id');
    }

    public function taxi()
    {
        return $this->hasMany(Taxi::class, 'place_id');
    }

    public function traking()
    {
        return $this->hasMany(Traking::class, 'place_id');
    }
}
