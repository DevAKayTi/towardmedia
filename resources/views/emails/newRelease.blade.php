<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Email Verification</title>
    <style>
    /* CSS for the button */
    .red-button {
        border:none;
        background-color: #ffffff;
        color: #dc3545; /* Text color */
        font-size: 16px;
        cursor: pointer;
        
    }

    .red-button a{
        border-radius:5px;
        /* border: 1px solid #dc3545; Red border */
        padding: 10px 5px;
        color: white; /* Text color */
        text-decoration: none;
        background-color: #004CC5;
        transition: background-color 0.3s ease;
    }

    .red-button:hover a{
        background-color:#0063E2;
    }
</style>
</head>
<body style="margin: 0; padding: 30px; font-family: Arial, sans-serif; background-color: #e9ecef;">
    <table role="presentation" width="100%" cellspacing="0" cellpadding="0" style="background-color: #e9ecef;border:0; font-family: Arial, sans-serif;">
        <tr>
            <td style="text-align: center">
                <table role="presentation" width="600" cellspacing="0" cellpadding="0" style="margin: auto;border:0">
                    <tr>
                        <td style="padding: 20px 0; text-align: center; background-color:#ffffff;">
                            <a class="navbar-brand" href="https://www.towardsmedia.com">
                                <img src="https://www.towardsmedia.com/assets/logo/logo.png" alt=" " width="120" style="max-width: 100%;">
                            </a>
                        </td>
                    </tr>
                    <tr>
                        <td style="padding: 30px 40px 10px; background-color: #ffffff;text-align: left;">
                            <p style="margin-top: 0; margin-bottom: 22px; font-size: 20px; font-weight: bold; line-height: 1.5; color: #333333;">{{strip_tags($description)}}</p>
                            <p style="margin-top: 0; margin-bottom: 20px; font-size: 16px;  color: #666666;">ဆီသို့စာစဉ် {{$postTitle}} ထွက်ရှိပြီ</p>
                            <p style="margin-top: 0; margin-bottom: 20px; font-size: 16px; line-height: 1.5; color: #666666;"></p>
                            <div style="margin-bottom: 20px;">
                                <img src="https://www.towardsmedia.com/storage/uploads/featured/202403211914u.jpg" alt=" " width="100%" style="max-width: 100%;">
                            </div>
                            <button class="red-button"><a href="http://localhost:8000/p/{{$slug}}">ပိုမိုဖတ်ရှုရန်</a></button>
                        </td>
                    </tr>
                    <tr>
                        <td style="text-align: center;padding: 20px 0px 0px 20px;background-color: #ffffff;padding-bottom:40px;color:#666666">
                            Manage your email preferences or unsubscribe completely by <a href='http://localhost:8000/subscriber/{{ $email }}' style='color: #007bff; text-decoration: none;'>clicking here</a>
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