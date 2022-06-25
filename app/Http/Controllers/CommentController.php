<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Comment;
use App\Models\Post;
use Illuminate\Support\Facades\Auth;
use App\Models\Notification;

class CommentController extends Controller
{
    public function add(Request $request){
        if ($request->body == ""){
            return response()->json([
                'message' => 'Body is required'
            ]);
        }
        Comment::create([
            'body' => $request->body,
            'user_id' => Auth::user()->id,
            'post_id' => $request->post_id
        ]);
        $post = Post::find($request->post_id);
        $post->increment('comments_count');

        $user = $post->user;
        $id_channel = $user->notifications->id;

        if ($id_channel != Auth::user()->notifications->id){
            Notification::create([
                'body' => 'berkomentar dipostinganmu',
                'type' => 'comment',
                'user_id' => Auth::user()->id,
                'channel_notification_id' => $id_channel
            ]);
        }
        $user->increment('unread_notif');


        $comment = Comment::where('post_id', $request->post_id)->get();

        foreach ($comment as $c) {
            $c->user;
        }

        return $comment;
    }
}
