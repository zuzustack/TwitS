<?php

namespace App\Http\Controllers;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use File;

class ImageController extends Controller
{
    public function uploadTempImage(Request $request){

        if (File::exists(Auth::user()->tempImage) && Auth::user()->tempImage != "storage/default-avatar.png"){
            unlink(Auth::user()->tempImage);
        }


        $token = Str::random(10);
        $file = $request->file('image');
        $filename = Auth::user()->username . "-" . $token .'.' . $file->extension();
        $file->move(public_path('storage/image/user'), $filename);

        $user = Auth::user();
        $user->tempImage = 'storage/image/user/' . $filename;
        $user->save();

        return [
            'tempImage' => $user->tempImage
        ];
    }
}
