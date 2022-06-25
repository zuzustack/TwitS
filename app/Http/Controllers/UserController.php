<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Models\User;
use App\Models\channelNotification;
use App\Models\Notification;
use Illuminate\Http\Request;
use Illuminate\Support\MessageBag;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use File;
use Validator;

class UserController extends Controller
{

    public function index($id){
        if (is_int(intval($id)) && intval($id) != 0){
            return response()->json( User::find($id) , 200);;
        }else{
            return response()->json(User::where('username',$id)->first(), 200);
        }
    }

    public function getNotif(){
        $user = User::find(Auth::user()->id);
        $user->unread_notif = 0;
        $user->save();
        $notifications = $user->notifications->getNotif;
        foreach ($notifications as $notification) {
            $notification->user;
        }
        // $notification->user;
        return [
            'notifications' => $notifications
        ];
    }



    public function userPost($id){
        $posts = User::find($id)->posts;

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

    // edit user
    public function uploadImage(Request $request){
        if ($request->file('image')){
            if (File::exists(Auth::user()->image) && !Auth::user()->image == "storage/default-avatar.png"){
                unlink(Auth::user()->image);
            }

            $token = Str::random(10);
            $file = $request->file('image');
            $filename = Auth::user()->username . "-" . $token .'.' . $file->extension();
            $file->move(public_path('storage/image/user'), $filename);


            $user = Auth::user();
            $user->image = 'storage/image/user/' . $filename;
            $user->save();
        }


        if (isset($request->name)){
            $user = Auth::user();
            $user->name = $request->name;
            $user->save();
        }

        if (isset($request->bio)){
            $user = Auth::user();
            $user->bio = $request->bio;
            $user->save();
        }

        return response()->json([
            'message' => True
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

        User::create([
            'name' => $user['name'],
            'email' => $user['email'],
            'username' => $user['username'],
            'password' => bcrypt($user['password']),
        ]);
        $user =User::orderBy('created_at','desc')->first();

        channelNotification::create([
            'user_id' => $user->id
        ]);

        return [
            'success' => true,
            'message' => "Berhasil Membuat Akun"
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
}
