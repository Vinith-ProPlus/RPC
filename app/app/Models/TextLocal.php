<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TextLocal extends Model
{
    use HasFactory;

    public function sendOTP($mobileNumber, $message){
        $apiKey = urlencode(config('app.TEXT_LOCAL_API_KEY'));
        
        $numbers = [$mobileNumber];
        $sender = urlencode(config('app.TEXT_LOCAL_SENDER_NAME'));
        $message = rawurlencode($message);
    
        $numbers = implode(',', $numbers);
    
        $data = array('apikey' => $apiKey, 'numbers' => $numbers, "sender" => $sender, "message" => $message);
        $ch = curl_init('https://api.textlocal.in/send/');
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $response = curl_exec($ch);
        curl_close($ch);
        
        info($response);
        $responseData = json_decode($response, true);

        if ($responseData['status']=='failure') {
            return ['status' =>false, 'message'=>'OTP Send Failed', 'errors' =>$responseData['errors']];
        } else {
            return ['status' =>true, 'message'=>'OTP Sent Successfully', 'response' =>$responseData];
        }
    }
    
}
