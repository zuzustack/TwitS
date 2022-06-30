<?php

namespace App\Http\Controllers;

use Mail;
use Illuminate\Http\Request;
use App\Mail\ConfirmEmailMail;
use App\Mail\ResetPasswordMail;

class EmailController extends Controller{
    public static function SendConfirmEmail($email,$username){
        Mail::to($email)->send(new ConfirmEmailMail($username));
    }

    public static function SendResetPassword($email, $username){
        Mail::to($email)->send(new ResetPasswordMail($username));
    }
}
