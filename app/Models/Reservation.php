<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Reservation extends Model
{
    use HasFactory;

    protected $table = 'reservations';
    protected $fillable = [
        'user_id',
        'no_reservation',
        'reservation_date',
        'item',
        'quantity'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
