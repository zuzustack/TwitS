<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Like;
class ChannelLike extends Model
{
    use HasFactory;

    protected $guarded =[
        'id',
    ];

    public function user(){
        return $this->belongsTo(User::class);
    }

    public function getPost(){
        return $this->hasMany(Like::class);
    }

}
