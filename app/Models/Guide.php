<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Guide extends Model
{
    use HasFactory;

    protected $table = 'guides';

    protected $fillable = [
        'user_id',
        'place_id',
        'name',
        'designation',
        'image',
        'status'
    ];
}
