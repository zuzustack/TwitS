<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Models\User;
use App\Models\channelNotification;
use App\Models\ChannelLike;
use App\Models\ChannelFollower;
use App\Models\ChannelFollowing;
use App\Models\Notification;
use App\Models\Like;
use App\Models\Follower;
use App\Models\Following;
use Illuminate\Http\Request;
use Illuminate\Support\MessageBag;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use App\Http\Controllers\EmailController;
use File;
use Validator;

class UserController extends Controller
{

    // Find User
    public function index($id){
        if (is_int(intval($id)) && intval($id) != 0){
            return response()->json( User::find($id) , 200);;
        }else{
            return response()->json(User::where('username',$id)->first(), 200);
        }
    }

    // Get Notification
    public function getNotif(){
        $user = Auth::user();
        $user->unread_notif = 0;
        $user->save();
        $notification = Notification::where('channel_notification_id',$user->notifications->id)
                                    ->orderBy('created_at','desc')->get();

        foreach ($notification as $notif) {
            $notif->user;
        };

        return[
            'notifications' => $notification
        ];
    }

    // get User Post
    public function userPost($id){
        $posts = User::find($id)->posts;

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
            'date' => $date
        ];
    }

    // edit user
    public function updateUser(Request $request){
        // Menghapus foto yang sudah ada untuk diganti foto baru
        $user = Auth::user();

        if (File::exists($user->image) && $user->image != "storage/default-avatar.png" && $user->tempImage != ""){
            unlink($user->image);

        }
        if ($user->tempImage != ""){
            $user->image = $user->tempImage;
        }
        $user->tempImage = "";
        $user->save();

        if (isset($request->name)){
            $user->name = $request->name;
            $user->save();
        }

        if (isset($request->bio)){
            $user->bio = $request->bio;
            $user->save();
        }

        return response()->json([
            'message' => True,
            'bio' => $user->bio,
            'name' => $user->name,
            'image' => $user->image,
        ], 200);
    }

    // Register
    public function register(Request $request){
        $validator = Validator::make(
            $request->all(),[
                'email' => 'required|unique:users|email',
                'name' => 'required',
                'username' => 'required|unique:users',
                'password'=> 'required|min:3',
                'pass_confirm'  => 'required|same:password|min:3'
            ]
        );

        if ($validator->fails()){
            return [
                'error' => true,
                'message' => $validator->messages()
            ];
        }

        $user = collect($request->all());

        $user = User::create([
            'name' => $user['name'],
            'email' => $user['email'],
            'username' => "@" . $user['username'],
            'password' => bcrypt($user['password']),
        ]);
        $user =User::orderBy('created_at','desc')->first();

        channelNotification::create([
            'user_id' => $user->id
        ]);

        ChannelLike::create([
            'user_id' => $user->id
        ]);

        ChannelFollower::create([
            'user_id' => $user->id
        ]);

        ChannelFollowing::create([
            'user_id' => $user->id
        ]);

        EmailController::SendConfirmEmail($user->email, $user->username);

        return [
            'success' => true,
            'message' => "Berhasil Membuat Akun, silahkan"
        ];

    }

    // LOGIN
    public function login(Request $request){
        $validator = Validator::make(
            $request->all(),[
                'email' => 'required|min:5|email',
                'password'=> 'required|min:3'
            ]
        );
        if ($validator->fails()){
            return response()->json([
                'error' => true,
                'message' => $validator->messages()
            ], 200);
        };

        $user = $request->all();
        // return [
        //     $validate = Auth::attempt($request->only(['email','password']))
        // ];

        if (Auth::attempt(['email' => $user['email'], 'password' => $user['password']])) {
            $request->session()->put('isLogin',true);
            return response()->json([
                'success' => true,
                'message' => "Login Success",
                'user' => Auth::user(),
            ], 200);
        }else {
            return response()->json([
                'error' => true,
                'message' => [
                    "err" => "Password atau Email salah"
                ],
            ],201);
        }
    }

    // get session user
    public function getSession(Request $request){

        if ($request->session()->get('isLogin') == null){
            $request->session()->put('isLogin',false);
        }
        return $request->session()->all();
    }

    // ==Logout
    public function logout(Request $request){
        $request->session()->flush();
        Auth::logout();
        return response()->json([
            'success' => true,
            'message' => "Logout Success"
        ], 200);
    }

    public function follow(Request $request){
        $user = User::where('username',$request->username)->first();
        $followed = $request->followed;
        $id_channel = $user->notifications->id;
        $check = Following::where('user_id',$user->follower->id )
                            ->where('channel_following_id', Auth::user()->id)->first();

        if (!$followed && $check == null){
            Follower::create([
                'user_id' => Auth::user()->id,
                'channel_follower_id' => $user->follower->id,
            ]);

            Following::create([
                'user_id' => $user->id,
                'channel_following_id' => Auth::user()->following->id
            ]);
            $user->increment('followers_count');
            Auth::user()->increment('followings_count');

            if ($id_channel != Auth::user()->notifications->id){
                Notification::create([
                    'body' => 'mengikuti anda',
                    'type' => 'user',
                    'user_id' => Auth::user()->id,
                    'channel_notification_id' => $id_channel
                ]);

                $user->increment('unread_notif');
            }

        }else{
            Follower::where('user_id' ,Auth::user()->id)
                    ->where('channel_follower_id', $user->follower->id)->first()->delete();
            Following::where('user_id',$user->follower->id )
                    ->where('channel_following_id', Auth::user()->id)->first()->delete();
            $user->decrement('followers_count');
            Auth::user()->decrement('followings_count');

        };
    }

    public function checkFollow(Request $request){
        $user = Auth::user();
        $followers = [];
        $channel = $user->following->getFollowing;
        foreach ($channel as $fw) {
            if ($fw->user->username == $request->username){
                return[
                    'status' => true
                ];
            };
        };

        return [
            'status' => false
        ];
    }

    // get Follower
    public function getFollower(Request $request){
        $user = User::find($request->id);
        $channel = $user->follower->getFollower;
        $followers = [];
        foreach ($channel as $fw) {
            array_push($followers, $fw->user);
        };

        return [
            'followers' => $followers
        ];
    }

    public function getFollowing(Request $request){
        $user = User::find($request->id);
        $channel = $user->following->getFollowing;
        $followings = [];
        foreach ($channel as $fw) {
            array_push($followings, $fw->user);
        };

        return [
            'followings' => $followings
        ];
    }

    public function cancelUpdateUser(){

    }
}
