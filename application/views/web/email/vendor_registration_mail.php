<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Vendor Registration Email</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f6f9;
            margin: 0;
            padding: 0;
        }

        .container {
            max-width: 700px;
            background-color: #ffffff;
            border-radius: 8px;
            padding: 20px;
            border: 1px solid #ddd;
        }

        .header {
            text-align: center;
            padding: 20px 0;
        }

        .header img {
            max-width: 150px;
        }

        .welcome-image {
            text-align: center;
            margin: 20px 0;
        }

        .welcome-image img {
            max-width: 100%;
            height: auto;
        }

        h2 {
            text-align: center;
            color: #333;
            margin-bottom: 10px;
        }

        h3 {
            color: #2c3e50;
            margin-bottom: 10px;
        }

        p {
            text-align: center;
            color: #555;
            line-height: 1.5;
            margin: 10px 0;
        }

        .button-container {
            text-align: center;
            margin: 30px 0;
        }

        .verify-button {
            background-color: #27ae60;
            color: #ffffff;
            padding: 12px 25px;
            border-radius: 5px;
            text-decoration: none;
            font-weight: bold;
            display: inline-block;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }

        table td {
            border: 1px solid #ddd;
            padding: 8px;
        }

        table tr:nth-child(even) {
            background-color: #f9f9f9;
        }

        .note {
            font-size: 13px;
            color: #7f8c8d;
            text-align: center;
            margin: 15px 0;
        }

        .footer {
            background-color: #1a1a1a;
            color: #ffffff;
            padding: 20px;
            text-align: center;
            font-size: 12px;
            margin-top: 40px;
        }

        .footer a {
            color: #fa582b;
            text-decoration: none;
        }

        .footer p {
            color: #ffffff;
        }
    </style>
</head>

<body>

    <div class="container">

        <!-- Header -->
        <div class="header">
            <img src="http://localhost/chenna/plugins/images/logo.png" alt="Chenna Logo">
            <p style="margin:8px 0 0;font-size:13px;">
                <a href="https://www.chenna.co">www.chenna.co</a>
            </p>
        </div>

        <!-- Welcome Image -->
        <div class="welcome-image">
            <img src="https://themes.pixelstrap.com/fastkart/email-templete/images/welcome-poster.jpg" alt="Welcome">
        </div>

        <!-- Welcome Text -->
        <h2>Hi <?= $name; ?> and Welcome to Chenna.co!</h2>
        <p>
            We hope our platform helps your business grow and reach new customers.
            Your vendor registration request has been received successfully.
        </p>

        <!-- Status Button -->
        <div class="button-container">
            <span class="verify-button">
                Current Status: Waiting for Admin Approval
            </span>
        </div>

        <!-- Message -->
        <p>
            Our admin team will review your submitted details and documents.
            Once approved, you will receive another email with your
            <b>login credentials</b>.
        </p>

        <!-- Vendor Details Table -->
        <h3>Your Submitted Details</h3>
        <table>
            <tr>
                <td><b>Full Name</b></td>
                <td><?= $name; ?></td>
            </tr>
            <tr>
                <td><b>Shop Name</b></td>
                <td><?= $shop_name; ?></td>
            </tr>
            <tr>
                <td><b>Mobile</b></td>
                <td><?= $mobile; ?></td>
            </tr>
            <tr>
                <td><b>Email</b></td>
                <td><?= $email; ?></td>
            </tr>
            <tr>
                <td><b>Address</b></td>
                <td><?= $address; ?></td>
            </tr>
            <tr>
                <td><b>City</b></td>
                <td><?= $city; ?></td>
            </tr>
            <tr>
                <td><b>State</b></td>
                <td><?= $state; ?></td>
            </tr>
            <tr>
                <td><b>Pincode</b></td>
                <td><?= $pincode; ?></td>
            </tr>
            <tr>
                <td><b>GST Number</b></td>
                <td><?= $gst_number; ?></td>
            </tr>
        </table>

        <!-- Note -->
        <p class="note">
            <b>Note:</b> At the moment, you cannot log in to your account. After admin approval, we will send your login details in a separate email.
        </p>

        <!-- Best Regards -->
        <div style="margin:20px 0; color:#2c3e50; font-size:14px;">
            <p style="margin:0;">Best Regards,</p>
            <p style="margin:5px 0;"><b>Chenna.co Team</b></p>
            <p style="margin:5px 0;">
                <a href="https://www.chenna.co">www.chenna.co</a>
            </p>
        </div>

        <!-- Footer -->
        <div class="footer">
            <p>
                <a href="https://www.chenna.co">www.chenna.co</a>
            </p>
            <p>New Jiamau, Hazratganj, Lucknow, UP – 226001</p>
            <p>📞 +91 98380 75493 | ✉ info@auctech.in</p>
            <p style="margin-top:10px;">© 2026 <b>Chenna.co</b>. All rights reserved.</p>
        </div>

    </div>

</body>

</html>