<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Follower extends Model
{
    use HasFactory;

    protected $guarded = [
        'id'
    ];

    public function channel(){
        return $this->belongsTo(ChannelFollower::class);
    }

    public function user(){
        return $this->belongsTo(User::class);
    }
}
