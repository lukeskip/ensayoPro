<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title></title>
</head>
<body style="background: #eeeeee;padding-top: 100px;">
    <table style="background: white;width:100%;max-width:600px;margin:auto; border-radius: 10px;">
        <tr >
            <td style="padding: 50px 40px;text-align: center">
                <img width="200px" src="{{asset('img/logo_rey.png')}}" alt="">
            </td>
        </tr>
        <tr>
            <td style="padding: 50px 40px;text-align: center">@yield('content')</td>
        </tr>
        <tr>
            <td style="padding: 50px 40px;text-align: center">Rey Decibel, 2017</td>
        </tr>
    </table>
    
</body>
</html>