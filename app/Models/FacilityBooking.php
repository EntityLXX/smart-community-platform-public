<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class FacilityBooking extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'facility',
        'purpose',
        'date',
        'start_time',
        'end_time',
        'status',
        'admin_notes',
    ];

    // Optional: relationship to User
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
