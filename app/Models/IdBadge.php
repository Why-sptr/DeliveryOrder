<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class IdBadge extends Model
{
    use HasFactory;

    protected $table = 'id_badges';
    protected $fillable = ['badge_name'];

    public function users()
    {
        return $this->belongsToMany(User::class, 'id_badge_user', 'id_badge_id', 'user_id');
    }

    public function reservations()
    {
        return $this->hasMany(Reservation::class);
    }
}
