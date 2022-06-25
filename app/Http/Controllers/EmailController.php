<?php

namespace App\Http\Controllers;
use App\Mail\TestMail;
use Illuminate\Support\Facades\Mail;
use Illuminate\Http\Request;

class EmailController extends Controller
{
    public function test(){
        Mail::to('ridwanyamada@gmail.com')->send(new TestMail());

        return [
            'Email Sended'
        ];
    }
}
