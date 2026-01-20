<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Vendor Approved</title>

    <style>
        body{
            font-family: Arial, sans-serif;
            background-color:#f4f6f9;
            margin:0;
            padding:0;
        }

        .container{
            max-width:700px;
            background:#ffffff;
            border-radius:8px;
            padding:20px;
            border:1px solid #ddd;
            margin-left:0;   /* LEFT */
            margin-right:auto;
        }

        .header{
            text-align:center;
            padding:20px 0;
        }

        .header img{
            max-width:150px;
        }

        .welcome-image{
            text-align:center;
            margin:20px 0;
        }

        .welcome-image img{
            max-width:100%;
            height:auto;
        }

        h2{
            text-align:center;
            color:#333;
            margin-bottom:10px;
        }

        p{
            color:#555;
            line-height:1.5;
            margin:10px 0;
        }

        .button-container{
            text-align:center;
            margin:30px 0;
        }

        .verify-button{
            background:#27ae60;
            color:#fff;
            padding:12px 25px;
            border-radius:5px;
            font-weight:bold;
            display:inline-block;
        }

        table{
            width:100%;
            border-collapse:collapse;
            margin-top:15px;
        }

        table th, table td{
            border:1px solid #ddd;
            padding:10px;
            text-align:left;
        }

        table tr:nth-child(even){
            background:#f9f9f9;
        }

        .note{
            font-size:13px;
            color:#7f8c8d;
            margin-top:10px;
            text-align:center;
        }

        .text-left{
            text-align:left;
        }

        .footer{
            background:#1a1a1a;
            color:#ffffff;
            padding:20px;
            font-size:12px;
            margin-top:40px;
            text-align:center;
        }

        .footer a{
            color:#d54f0de3;
            text-decoration:none;
        }
    </style>
</head>

<body>

<div class="container">

    <!-- Header -->
    <div class="header">
        <img src="<?= base_url('../plugins/images/loho.png'); ?>" alt="Chenna Logo">
        <p style="font-size:13px;">
           
        </p>
    </div>

    <!-- Banner -->
    <div class="welcome-image">
        <img src="<?= base_url('../plugins/images/welcome-poster.jpg'); ?>" alt="Welcome">
    </div>

    <!-- Title -->
    <h2>Hi <?= $name; ?>, Welcome to Chenna.co!</h2>

    <p class="text-left">
        We are pleased to inform you that your <b>Vendor Account</b> has been
        <b>successfully approved.</b>
    </p>

    <!-- Status -->
    <div class="button-container">
        <span class="verify-button">Your Account : Activate / Approved</span>
    </div>

    <!-- Login Info -->
    <p>
        You can now log in using the credentials below:
    </p>

    <table>
        <tr>
            <th>Mobile</th>
            <td><?= $mobile; ?></td>
        </tr>
        <tr>
            <th>Password</th>
            <td><?= $password; ?></td>
        </tr>
    </table>

    <p style="text-align: center;margin-top:20px">
        After logging in, you can start managing your shop, products, and orders.
    </p>

    <!-- Note -->
    <p class="note">
        <b>Note:</b> For security reasons, please change your password after your first login.
    </p>

    <!-- Best Regards -->
    <div class="text-left" style="margin-top:25px;">
        <p style="margin:0;">Best Regards,</p>
        <p style="margin:5px 0;"><b>Team Chenna.co</b></p>
        
    </div>

    <!-- Footer -->
    <div class="footer">
        <p><a href="https://www.chenna.co" style="color:oranged">www.chenna.co</a></p>
        <p style="color:white">New Jiamau, Hazratganj, Lucknow, UP – 226001</p>
        <p style="color:white">📞 +91 98380 75493 | ✉ info@auctech.in</p>
        <p style="margin-top:10px;color:white">© 2026 <b>Chenna.co</b>. All rights reserved.</p>
    </div>

</div>

</body>
</html>
