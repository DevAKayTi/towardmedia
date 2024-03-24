<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Email Verification</title>
</head>
<body style="margin: 0; padding: 30px; font-family: Arial, sans-serif; background-color: #e9ecef;">
    <table role="presentation" width="100%" cellspacing="0" cellpadding="0" style="background-color: #e9ecef;border:0; font-family: Arial, sans-serif;">
        <tr>
            <td style="text-align: center">
                <table role="presentation" width="600" cellspacing="0" cellpadding="0" style="margin: auto;border:0">
                    <tr>
                        <td style="padding: 20px 0; text-align: center;background-color:#ffffff;">
                        <a class="navbar-brand" href="https://www.towardsmedia.com">
                            <img src="https://www.towardsmedia.com/assets/logo/logo.jpeg" alt=" " width="120" style="max-width: 100%;">
                        </a>
                        </td>
                    </tr>
                    <tr>
                        <td style="padding: 30px 40px 10px; background-color: #ffffff;text-align: center;">
                            <h3 style="margin-top: 0; margin-bottom: 20px; font-size: 24px; font-weight: bold; color: #333333;">Verify your email address</h3>
                            <p style="margin-top: 0; margin-bottom: 20px; font-size: 16px; line-height: 1.5; color: #666666;">Please confirm that you want to use as your email address. Once it's done, you will be subscribed to our website.</p>
                            <p style="margin-top: 0; margin-bottom: 20px; font-size: 16px; line-height: 1.5; color: #666666;">
                                <a href='http://localhost:8000/verify/<?php echo $token ?>' style="display: inline-block; padding: 10px 20px; background-color: #dc3545; color: #ffffff; text-decoration: none; font-size: 16px; font-weight: bold; border-radius: 5px;cursor:pointer">Verify my email</a>
                            </p>
                        </td>
                    </tr>
                    <tr>
                        <td style="text-align: center;padding-top: 10px;background-color: #ffffff;padding-bottom:40px">
                            <p style="margin: 0; font-size: 14px; color: #666666;">&copy; <span id="currentYear">{{date('Y')}}</span> towardsmedia.com. <a href="https://www.towardsmedia.com/privacy-policy" style="color: #dc3545; text-decoration: none;">Privacy & Policy</a></p>
                        </td>
                    </tr>
                </table>
            </td>
        </tr>
    </table>
</body>
</html>