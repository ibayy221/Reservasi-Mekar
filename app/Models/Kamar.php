<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Kamar extends Model
{
    use HasFactory;

    protected $table = 'kamar';

    protected $fillable = [
        'name', 'slug', 'price', 'capacity', 'stock', 'description', 'image'
    ];

    public function reservasi()
    {
        return $this->hasMany(Reservasi::class, 'kamar_id');
    }
}
