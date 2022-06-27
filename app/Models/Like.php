<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\ChannelLike;
class Like extends Model
{
    use HasFactory;

    protected $guarded = [
        'id'
    ];

    public function channel(){
        return $this->belongsTo(ChannelLike::class);
    }

    public function post(){
        return $this->belongsTo(Post::class);
    }
}
