<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title></title>
</head>
<body style="background: #eeeeee;padding-top: 100px;padding-bottom: 100px;">
    <table style="background: white;width:100%;max-width:600px;margin:auto; border-radius: 10px; font-family:arial;" cellspacing="0" cellpadding="0">
        <tr >
            <td style="padding: 30px 40px;background:black;text-align: center;color:white">
                <img width="200px" src="{{asset('img/logo_rey.png')}}" alt="Rey Decibel">
                <p style="text-align: center;">Presenta</p>
            </td>
        </tr>
        <tr >
            <td style="padding:0;padding-top:40px;text-align:center">
                @yield('image')
            </td>
        </tr>
        <tr>
            <td style="padding: 20px 40px 20px 40px;text-align: center">@yield('content')</td>
        </tr>
        <tr style="background: black;border-radius: 10px;">
            <td style="padding: 20px 40px;text-align: center;color:white"><img width="150px" src="{{asset('img/logo_rey.png')}}" alt=""><br>Todos los derechos reservados, 2017</td>
        </tr>
    </table>
    
</body>
</html>