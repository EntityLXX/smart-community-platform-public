<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Thread;

class ThreadView extends Model
{
    protected $fillable = [
        'thread_id',
        'user_id',
    ];


    public function thread()
    {
        return $this->belongsTo(Thread::class);
    }

}
