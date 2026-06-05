<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class KamarAvailability extends Model
{
    use HasFactory;

    protected $table = 'kamar_availabilities';

    protected $fillable = [
        'kamar_id', 'date', 'available',
    ];

    public function kamar()
    {
        return $this->belongsTo(Kamar::class, 'kamar_id');
    }
}
