<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Choice extends Model
{
    use HasFactory;

    protected $fillable = [
        'voting_id',
        'name',
    ];

    public function voting()
    {
        return $this->belongsTo(Voting::class);
    }

    public function votes()
    {
        return $this->hasMany(Vote::class);
    }

}
