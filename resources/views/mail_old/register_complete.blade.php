<!doctype html>
<html lang="">
<head>
    <meta name="viewport" content="width=device-width"/>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8"/>
    <title></title>
</head>
<body class="">
<h1>{{$header}}</h1>
<p>{!!$text!!}</p>
</body>
</html>
<div style="margin:0;padding:0;width:100%!important">
    <table cellpadding="0" cellspacing="0" width="100%" bgcolor="#EDEFF1"
           style="border-collapse:collapse;background-color:#edeff1" dir="ltr">
        <tbody>
        <tr>
            <td style="border-collapse:collapse;padding:40px 10px 40px 10px">
                <font color="#888888">
                </font>
                <table cellpadding="0" cellspacing="0" align="center" width="600"
                       style="border-collapse:collapse;background-color:#ffffff;border:1px solid #edeff1">
                    <tbody>
                    @include('mail.header')
                    <tr style="background-color:#aeafaf">
                        <td style="border-collapse:collapse;padding:20px 30px">
                            <h1 style="color:#fff;font-size:20px;font-weight:400;text-transform:uppercase">{{$header}}</h1>
                        </td>
                    </tr>
                    <tr>
                        <td style="border-collapse:collapse;padding:30px;color:#333333;font-family:Montserrat,sans-serif,Helvetica,Arial,sans-serif;font-size:16px">
                            {!!$text!!}
                            <h4
                                style="color:#333333;border-bottom:1px solid #d4d4d4;font-size:1em;font-weight:700;padding-bottom:10px;text-transform:uppercase">
                                Օգտատիրոջ տվյալներ</h4>
                            <table border="0" width="100%" style="border-collapse:collapse">
                                <tbody>
                                <tr>
                                    <td style="border-collapse:collapse;color:#333333;font-family:Montserrat,sans-serif,Helvetica,Arial,sans-serif;font-size:16px;padding:5px">
                                        <b>Login URL:</b></td>
                                    <td style="border-collapse:collapse;color:#333333;font-family:Montserrat,sans-serif,Helvetica,Arial,sans-serif;font-size:16px;padding:5px">
                                        <a href="{{route('home')}}"
                                           style="outline:none;color:#aeafaf" target="_blank"
                                        >{{route('home')}}</a>
                                    </td>
                                </tr>
                                <tr>
                                    <td style="border-collapse:collapse;color:#333333;font-family:Montserrat,sans-serif,Helvetica,Arial,sans-serif;font-size:16px;padding:5px">
                                        <b>էլ․ հասցե:</b></td>
                                    <td style="border-collapse:collapse;color:#333333;font-family:Montserrat,sans-serif,Helvetica,Arial,sans-serif;font-size:16px;padding:5px">
                                        <a style="outline:none;color:#aeafaf">{{$user->email}}</a></td>
                                </tr>
                                <tr>
                                    <td style="border-collapse:collapse;color:#333333;font-family:Montserrat,sans-serif,Helvetica,Arial,sans-serif;font-size:16px;padding:5px">
                                        <b>Գաղտնաբառ:</b></td>
                                    <td style="border-collapse:collapse;color:#333333;font-family:Montserrat,sans-serif,Helvetica,Arial,sans-serif;font-size:16px;padding:5px">
                                        *********** (<a
                                            href="{{route('home')}}"
                                            style="outline:none;color:#aeafaf" target="_blank"
                                        >Մոռացե՞լ
                                            եք գաղտնաբառը:</a>)
                                    </td>
                                </tr>
                                </tbody>
                            </table>
                            <br>
                            @if(false)
                            <table width="269" align="left" style="border-collapse:collapse"><tbody><tr><td style="border-collapse:collapse;color:#333333;font-family:Montserrat,sans-serif,Helvetica,Arial,sans-serif;font-size:16px;padding:5px">
                                        <h4 style="color:#333333;border-bottom:1px solid #d4d4d4;font-size:1em;font-weight:700;padding-bottom:10px;text-transform:uppercase">Վճարողի հասցե</h4>
                                        <strong>Arman Saftalyan</strong><br>
                                        qweqwe qweqwe<br>
                                        qweqwe AM <br>
                                        +37493163661 <br></td>
                                </tr></tbody></table>
                            @endif
                            @if(false)
                            <table width="269" align="left" style="border-collapse:collapse"><tbody><tr><td style="border-collapse:collapse;color:#333333;font-family:Montserrat,sans-serif,Helvetica,Arial,sans-serif;font-size:16px;padding:5px">
                                        <h4 style="color:#333333;border-bottom:1px solid #d4d4d4;font-size:1em;font-weight:700;padding-bottom:10px;text-transform:uppercase">Առաքում Հասցե</h4>
                                        <strong>Arman Saftalyan</strong><br>
                                        qweqwe qweqwe<br>
                                        qweqwe AM <br>
                                        +37493163661 <br></td>
                                </tr></tbody></table>
                            @endif
                        </td>

                    </tr>
                    @include('mail.footer')
                    </tbody>
                </table>
            </td>
        </tr>
        </tbody>
    </table>
</div>
