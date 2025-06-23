<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Voting extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'description',
        'start_date',
        'end_date',
        'start_time',
        'end_time',
        'status',
    ];

    public function votes()
    {
        return $this->hasMany(Vote::class);
    }

    public function choices()
    {
        return $this->hasMany(Choice::class);
    }

}
