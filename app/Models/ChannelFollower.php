<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Follower;


class ChannelFollower extends Model
{
    use HasFactory;

    protected $guarded =[
        'id',
    ];

    public function user(){
        return $this->belongsTo(User::class);
    }

    public function getFollower(){
        return $this->hasMany(Follower::class);
    }
}
