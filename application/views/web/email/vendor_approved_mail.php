<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Vendor Approved</title>
</head>
<body style="font-family:Arial,sans-serif; background:#f4f6f9; padding:20px;">
    <div style="max-width:700px; margin:auto; background:#fff; border-radius:6px; padding:20px; border:1px solid #ddd;">
        <h2 style="color:#2c3e50;">Hello <?= $name; ?> 👋</h2>
        <p>Your vendor account has been <b>approved by Admin</b>.</p>
        <p>You can now login with the following credentials:</p>
        <table width="100%" cellpadding="8" cellspacing="0" style="border-collapse:collapse; border:1px solid #ddd;">
            <tr>
                <td style="border:1px solid #ddd;"><b>Mobile</b></td>
                <td style="border:1px solid #ddd;"><?= $mobile; ?></td>
            </tr>
            <tr>
                <td style="border:1px solid #ddd;"><b>Password</b></td>
                <td style="border:1px solid #ddd;"><?= $password; ?></td>
            </tr>
        </table>
        <p style="margin-top:20px;">Login to your account and start managing your shop.</p>
        <p>Thank you,<br><b>Team Chenna</b></p>
    </div>
</body>
</html>
