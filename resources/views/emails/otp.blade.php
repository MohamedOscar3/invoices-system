<!DOCTYPE html>
<html lang="en">
<head>
    <title>OTP Email</title>
    <style>
        /* Add your inline CSS styles here */
        body {
            font-family: Arial, sans-serif;
            background-color: #f2f2f2;
        }

        .container {
            max-width: 600px;
            margin: 0 auto;
            padding: 20px;
            background-color: #fff;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        p {
            font-size: 18px;
        }

        strong {
            color: #007bff;
        }
    </style>
</head>
<body>
<div class="container">
    <p>Your OTP is: <strong>{{ $otp }}</strong></p>
</div>
</body>
</html>
