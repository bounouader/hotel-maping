<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Room extends Model
{
    use HasFactory;

    protected $table = 'hotel_categorie_chambre';

    protected $fillable = [

        'categorie_id',
        'hotel_id',
        'name',
        'active',

    ];
     public function hotel()
     {
             return $this->belongsTo(Hotel::class, 'hotel_id');
     }

}
