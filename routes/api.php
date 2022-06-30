<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PostController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\EmailController;
use App\Http\Controllers\ImageController;


/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

// Post Controller
Route::get("/posts",[PostController::class,'index']);
Route::get("/post/{id}",[PostController::class,'singlePost']);
Route::get("/post/search/{s}",[PostController::class,'searchCaptPost']);
Route::get("/post/slug/{slug}",[PostController::class,'searchSlugPost']);
Route::post("/add/post",[PostController::class,'add']);
Route::get("/add/post",[PostController::class,'add']);
Route::post("/add/like/{id}",[PostController::class,'addLike']);
Route::post("/add/share/{id}",[PostController::class,'addShare']);
Route::post("/delete/post",[PostController::class,'delete']);


// User Controller
Route::get("/user/{id}",[UserController::class,'index']);
Route::get("/user/{id}/post",[UserController::class,'userPost']);
Route::post("/update/user",[UserController::class,'updateUser']);
Route::post("/upload/temp/user",[ImageController::class,'uploadTempImage']);
Route::get("/notification/user",[UserController::class, 'getNotif']);
Route::post("/follower/user",[UserController::class, 'getFollower']);
Route::post("/following/user",[UserController::class, 'getFollowing']);
Route::post("/follow",[UserController::class, 'follow']);

Route::post("/check-follow",[UserController::class, 'checkFollow']);


// Comment Controller
Route::post("/add/comment",[CommentController::class,'add']);
Route::get("/add/comment",[CommentController::class,'add']);


// Api Login Register
Route::group(['middleware' => ['web']], function () {
    Route::get("/set-session-default",[UserController::class,'setSession']);
    Route::get("/get-session",[UserController::class,'getSession']);


    Route::get("/login-user",[UserController::class,'login']);
    Route::get("/register-user",[UserController::class,'register']);
    Route::get("logout",[UserController::class,'logout']);

    Route::post("/login-user",[UserController::class,'login']);
    Route::post("/register-user",[UserController::class,'register']);
    Route::post("logout",[UserController::class,'logout']);
});


Route::get("/test-email",[EmailController::class,'test']);
