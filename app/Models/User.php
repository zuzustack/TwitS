<?php

namespace App\Models;

use Laravel\Sanctum\HasApiTokens;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User as Authenticatable;
use App\Models\channelNotification;
use App\Models\ChannelLike;
use App\Models\ChannelFollower;
use App\Models\ChannelFollowing;


class User extends Authenticatable
{
    use HasFactory, HasApiTokens;

    protected $guarded = [
        'id'
    ];

    public function posts()
    {
        return $this->hasMany(Post::class);
    }

    public function comments(){
        return $this->hasMany(Comment::class);
    }

    public function notifications(){
        return $this->hasOne(channelNotification::class);
    }

    public function like(){
        return $this->hasOne(ChannelLike::class);
    }

    public function follower(){
        return $this->hasOne(ChannelFollower::class);
    }

    public function following(){
        return $this->hasOne(ChannelFollowing::class);
    }
}
