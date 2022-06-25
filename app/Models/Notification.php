<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\User;
use App\Models\channelNotification;


class Notification extends Model
{
    use HasFactory;

    protected $guarded = [
        'id'
    ];

    public function channel(){
        return $this->belongsTo(channelNotification::class);
    }

    public function user(){
        return $this->belongsTo(User::class);
    }
}
