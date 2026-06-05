<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Reservasi extends Model
{
    use HasFactory;

    protected $table = 'reservasi';

    protected $fillable = [
        'user_id', 'kamar_id', 'check_in', 'check_out', 'nights', 'adults', 'children', 'total_price', 'status', 'payment_id',
        'reservation_code', 'smoking_preference', 'bed_setup', 'special_requests',
    ];


    public function kamar()
    {
        return $this->belongsTo(Kamar::class, 'kamar_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
