<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Password Reset</title>
</head>
<body style="font-family: 'Arial', sans-serif;">
<div style="max-width: 600px; margin: auto; padding: 20px; border: 1px solid #ccc; border-radius: 5px;">
    <h2 style="text-align: center; color: #333;">Password Reset</h2>
    <p style="color: #555;">Hello, {$nickname}!</p>
    <p style="color: #555;">You recently requested to reset your password for your account. Use the code below to reset it:</p>
    <div style="background-color: #f5f5f5; padding: 10px; text-align: center; font-size: 20px; color: #333; margin: 20px 0;">
        <strong>{{ $resetCode }}</strong>
    </div>
    <p style="color: #555;">If you did not request a password reset, please ignore this email or contact support if you have any questions.</p>
    <p style="color: #555;">Best regards,<br>Your Company Name</p>
</div>
</body>
</html>
