<?php

namespace App\Http\Controllers;

use App\Mail\MailSender;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;


class MailController extends Controller{
    
    public static function sendMail($data){
        Mail::to($data['email'])->send(new MailSender($data));
        return true;
    }
}
