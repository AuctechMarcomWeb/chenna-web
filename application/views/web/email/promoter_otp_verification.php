<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>OTP Verification</title>

    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f6f9;
            margin: 0;
            padding: 0;
        }

        .container {
            max-width: 700px;
            background: #ffffff;
            border-radius: 8px;
            padding: 20px;
            border: 1px solid #ddd;
            margin-left: 0;
            /* LEFT */
            margin-right: auto;
        }

        .header {
            text-align: center;
            padding: 20px 0;
        }

        .header img {
            max-width: 150px;
        }

        h2 {
            text-align: center;
            color: #333;
            margin-bottom: 10px;
        }

        p {
            color: #555;
            line-height: 1.5;
            margin: 10px 0;
        }

        .otp-button {
            background: #18a317;
            color: #fff;
            padding: 12px 25px;
            border-radius: 5px;
            font-weight: bold;
            display: inline-block;
            text-decoration: none;
            font-size: 16px;
        }

        .note {
            font-size: 13px;
            color: #7f8c8d;
            margin-top: 10px;
            text-align: center;
        }

        .footer {
            background: #1a1a1a;
            color: #ffffff;
            padding: 20px;
            font-size: 12px;
            margin-top: 40px;
            text-align: center;
        }

        .footer a {
            text-decoration: none;
            color: #d54f0de3;
        }
    </style>
</head>

<body>

    <div class="container">

        <!-- Header -->
        <div class="header">
            <img src="<?= base_url('../plugins/images/loho.png'); ?>" alt="Chenna Logo">
        </div>

        <!-- Title -->
        <h2>Hi <?= $name; ?>!</h2>

        <p>
            You are attempting to verify your email for your <b>Chenna.co</b> promoter account.
            Please use the OTP below to complete the verification process.
        </p>

        <!-- OTP Button -->
        <div style="text-align:center; margin:30px 0;">
            <span class="otp-button"><?= $otp; ?></span>
        </div>

        <p style="text-align:center; color:#555;">
            Enter this OTP in the verification field to confirm your email address.
            This OTP is valid for <b>10 minutes</b>.
        </p>

        <!-- Note -->
        <p class="note">
            If you did not request this verification, please ignore this email.
        </p>
        <div class="text-left" style="margin-top:25px;">
            <p style="margin:0;">Best Regards,</p>
            <p style="margin:5px 0;"><b>Team Chenna.co</b></p>

        </div>

        <!-- Footer -->
        <div class="footer">
            <p><a href="https://www.chenna.co">www.chenna.co</a></p>
            <p style="color:white;">New Jiamau, Hazratganj, Lucknow, UP – 226001</p>
            <p style="color:white;">📞 +91 98380 75493 | ✉ info@auctech.in</p>
            <p style="margin-top:10px;color:white">© 2026 <b>Chenna.co</b>. All rights reserved.</p>
        </div>

    </div>

</body>

</html>