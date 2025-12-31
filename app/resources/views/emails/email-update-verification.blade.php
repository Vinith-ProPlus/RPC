<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link href="https://fonts.googleapis.com/css2family=Poppins:wght@300;400;50;600&display=swap" rel="stylesheet" />
    <style>
        body {
            font-family: 'Poppins', sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 0;
        }
        .email-container {
            max-width: 600px;
            margin: 20px auto;
            background-color: #ffffff;
            padding: 20px;
            text-align: center;
        }
        .email-logo {
            margin-bottom: 20px;
        }
        .email-header {
            font-size: 24px;
            margin-bottom: 10px;
        }
        .email-body {
            font-size: 16px;
            line-height: 1.5;
            margin-bottom: 20px;
        }
        .email-code {
            font-size: 32px;
            letter-spacing: 20px;
            padding: 10px 0;
            margin-bottom: 20px;
            display: inline-block;
        }
        .email-footer {
            font-size: 14px;
            color: #666666;
            margin-top: 20px;
        }
      .email-footer span {
          color: #0f448d;
      }
    </style>
</head>
<body>
    <div class="email-container" style="border-radius: 2%">
        <div class="email-logo">
            {{-- <img loading="lazy" src="{{url('/')}}/{{$Logo}}" height="50px" alt="{{$CompanyName}}"> --}}
            <img loading="lazy" src="https://builderssupply.in/{{$Logo}}" height="50px" alt="{{$CompanyName}}">
        </div>
        <div class="email-header">
            Dear {{ $UserName }}
        </div>
        <div class="email-body">
            Thank you for initiating an email change request for your account at RPC {{$LoginType}} App. To ensure the security of your account, we've generated a one-time verification code that is valid for the next <strong>2 minutes</strong>.
        </div>
        <div class="email-code">
            <strong>{{ $OTP }}</strong>
        </div>
        <div class="email-body">
            If you did not initiate this email change request or have any concerns about the security of your account, please contact our support team immediately at<br>
            {{$CompanyEmail}}
        </div>
        <div class="email-footer">
            Best regards, <br>
            <span><strong>{{$CompanyName}}</strong></span>
        </div>
    </div>
</body>
</html>
