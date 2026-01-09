<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Vendor Registration</title>
</head>
<body style="font-family: Arial, sans-serif; background:#f4f6f9; padding:20px;">
    <div style="max-width:700px; margin:auto; background:#ffffff; border-radius:6px; padding:20px; border:1px solid #ddd;">

        <h2 style="color:#2c3e50;">Hello <?= $name; ?> 👋</h2>

        <p>
            Thank you for registering as a <b>Vendor</b> with us.  
            Your registration has been submitted successfully.
        </p>

        <p style="color:#e67e22;">
            <b>Current Status:</b> Waiting for Admin Approval
        </p>

        <p>
            Our admin team will review your details and documents.  
            Once your account is approved, we will send you another email with your
            <b>login details</b>.
        </p>

        <h3 style="margin-top:20px; color:#2c3e50;">Your Submitted Details</h3>

        <table width="100%" cellpadding="8" cellspacing="0" style="border-collapse:collapse; border:1px solid #ddd;">
            <tr>
                <td style="border:1px solid #ddd;"><b>Full Name</b></td>
                <td style="border:1px solid #ddd;"><?= $name; ?></td>
            </tr>
            <tr>
                <td style="border:1px solid #ddd;"><b>Shop Name</b></td>
                <td style="border:1px solid #ddd;"><?= $shop_name; ?></td>
            </tr>
            <tr>
                <td style="border:1px solid #ddd;"><b>Mobile</b></td>
                <td style="border:1px solid #ddd;"><?= $mobile; ?></td>
            </tr>
            <tr>
                <td style="border:1px solid #ddd;"><b>Email</b></td>
                <td style="border:1px solid #ddd;"><?= $email; ?></td>
            </tr>
            <tr>
                <td style="border:1px solid #ddd;"><b>Address</b></td>
                <td style="border:1px solid #ddd;"><?= $address; ?></td>
            </tr>
            <tr>
                <td style="border:1px solid #ddd;"><b>City</b></td>
                <td style="border:1px solid #ddd;"><?= $city; ?></td>
            </tr>
            <tr>
                <td style="border:1px solid #ddd;"><b>State</b></td>
                <td style="border:1px solid #ddd;"><?= $state; ?></td>
            </tr>
            <tr>
                <td style="border:1px solid #ddd;"><b>Pincode</b></td>
                <td style="border:1px solid #ddd;"><?= $pincode; ?></td>
            </tr>
            <tr>
                <td style="border:1px solid #ddd;"><b>GST Number</b></td>
                <td style="border:1px solid #ddd;"><?= $gst_number; ?></td>
            </tr>
        </table>

        <p style="margin-top:20px;">
            <b>Note:</b> At the moment, you cannot log in to your account.  
            After admin approval, we will send your login details in a separate email.
        </p>

        <p>
            If you have any questions, feel free to contact our support team.<br><br>
            Thank you for choosing us.<br>
            <b>Team Chenna</b>
        </p>
    </div>
</body>
</html>
