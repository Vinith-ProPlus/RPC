<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SMSAlert extends Model
{
    // $message: full text to send (can include OTP or template placeholder)
    // $templateId: optional template id to pass to SMSAlert API; if null, templateid will be omitted
    public function sendOTP($mobileNumber, $message, $templateId = null)
    {
        $username = config('services.smsalert.username');
        $password = config('services.smsalert.password');
        $senderId = config('services.smsalert.sender_id');

        $url = "https://www.smsalert.co.in/api/push.json";

        $postData = [
            "user"     => $username,
            "pwd"      => $password,
            "sender"   => $senderId,
            "mobileno" => $mobileNumber,
            "text"     => $message
        ];

        // Include template id only when explicitly provided
        if ($templateId) {
            $postData['templateid'] = $templateId;
        }

        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($postData));
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

        $response = curl_exec($ch);
        curl_close($ch);

        info('SMSAlert Response:', ['response' => $response]);

        $responseData = json_decode($response, true);

        if (isset($responseData['status']) && $responseData['status'] == 'success') {
            return [
                'status' => true,
                'message' => 'OTP Sent Successfully',
                'response' => $responseData
            ];
        }

        return [
            'status' => false,
            'message' => 'OTP Send Failed',
            'response' => $responseData
        ];
    }
}
