<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Hotel extends Model
{
    use HasFactory;
    protected $primaryKey = 'hotel_id';

    protected $fillable = [
        'hotel_id',
        'name',
        'phone',
        'address',
        'pms',
        'active',
    ];

    public function rooms()
    {
        return $this->hasMany(Room::class, 'categorie_id');

    }

}
