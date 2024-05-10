<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Mail;

class EmailSender extends Model
{
    public static function sendEmail($to, $subject, $view, $data)
    {
        try {
            Mail::send($view, $data, function($message) use ($to, $subject) {
                $message->to($to)->subject($subject);
            });
            return true;
        } catch (\Exception $e) {
            info("Email sending failed: " . $e->getMessage());
            return false;
        }
    }
}
