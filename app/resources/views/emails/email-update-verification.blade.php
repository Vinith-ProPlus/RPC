<!DOCTYPE html>
<html>
<head>
    <title>Email Update OTP</title>
</head>
<body>
    <p>Dear {{ $user->name }},</p>

    <p>Thank you for initiating an email change request for your account at {{$CompanyName}} {{$LoginType}} App. To ensure the security of your account, we've generated a one-time verification code that is valid for the next 2 minutes.</p>
    
    <p>Your One Time Password: <strong>{{ $OTP }}</strong></p>

    <p>Please enter this code in the designated field during the email change process immediately to confirm your new email address. This code will expire after 2 minutes for security reasons.</p>
    
    <p>If you did not initiate this email change request or have any concerns about the security of your account, please contact our support team immediately at {{$CompanyEmail}}.</p>

    <p>Thank you for entrusting us with your account security. We are here to assist you with any questions or concerns you may have.</p>

    <p>Best regards,</p>

    <p>{{$CompanyName}}</p>
</body>
</html>