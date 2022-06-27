<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Auth;
use Validator;
use App\Models\Like;
use App\Models\Notification;

class PostController extends Controller
{
    // get all post
    public function index(){

        // get latest post
        $posts = Post::orderBy('created_at','desc')->get();
        $date = [];

        foreach($posts as $post){
            array_push($date, $post->created_at->diffForHumans());
            $post->user;
            $check = Like::where('post_id', $post->id)
                        ->where('channel_like_id',Auth::user()->like->id)->get();
            if(count($check) == 0){
                $post['liked'] = false;
            }else{
                $post['liked'] = true;
            }
        }

        return [
            'posts' => $posts,
            'date' => $date,
        ];
    }

    // search single post by id
    public function singlePost($id){
        $date = Post::find($id)->created_at->diffForHumans();
        $post = Post::find($id);
        $post->user;
        $post->comments;
        foreach($post->comments as $comment){
            $comment->user;
        }
        return [
            'post'=> $post,
            'date' => $date
        ];
    }

    // search by caption post
    public function searchCaptPost($s){
        $posts = Post::where('caption', 'like', '%'.$s.'%')->get();
        $date = [];

        foreach($posts as $post){
            array_push($date, $post->created_at->diffForHumans());
            $post->user;
        }

        return [
            'posts' => $posts,
            'date' => $date
        ];
    }

    public function searchSlugPost($slug){
        $post = Post::where('slug',$slug)->first();

        if (!is_null($post)) {
            $post->user;
            $post->comments;
        }

        return response()->json([
            'post' => $post
        ]);
    }


    // add post
    public function add(Request $request){
        if ($request->caption == "") {
            return response()->json([
                'message' => 'Caption is required'
            ], 400);
        }
        $token = Str::random(10);
        Post::create([
            'slug' => $token,
            'user_id' => Auth::user()->id,
            'caption' => $request->caption,
            'likes_count' => 0,
            'share' => 0,
            'comments_count' => 0,
        ]);

        return response()->json([
            'message' => 'Post created'
        ], 201);
    }


    // search by user
    public function user(){
        $user = User::all();
        return [
            'user' => $user
        ];
    }

    // add like
    public function addLike($id){
        $post = Post::find($id);
        $user = $post->user;
        $check = Like::where('post_id',$id)
                    ->where('channel_like_id',Auth::user()->like->id)->get();
        if (count($check) == 0) {
            Like::create([
                'post_id' => $id,
                'channel_like_id' => Auth::user()->like->id
            ]);
            // Create notifikasi
            $id_channel = $user->notifications->id;
            if ($id_channel != Auth::user()->notifications->id){
                Notification::create([
                    'body' => 'menyukai postinganmu',
                    'type' => 'like',
                    'user_id' => Auth::user()->id,
                    'channel_notification_id' => $id_channel
                ]);
                $user->increment('unread_notif');
            }
            $status = "berhasil di like";
            $post->increment('likes_count');
        }else {
            Like::where('channel_like_id',Auth::user()->like->id)
                ->where('post_id',$id)->first()->delete();
            $status = "unlike";
            $post->decrement('likes_count');
        }

        return [
            $status
        ];
    }

    public function addShare($id){
        $post = Post::find($id);
        $post->increment('share');
        return response()->json([
            'message' => 'Like added'
        ], 201);
    }


    public function delete(Request $request){
        Post::find($request->id)->delete();
        return [
            "Success to delete"
        ];
    }
}
