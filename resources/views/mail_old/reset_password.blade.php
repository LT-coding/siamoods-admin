<!doctype html>
<html lang="">
<head>
    <meta name="viewport" content="width=device-width" />
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
    <title></title>
</head>
<body class="">
<h1>{{$header}}</h1>
<p>{!!$text!!}</p>
<a href="{{$url}}" style="border-radius: 4px;
    color: #fff;
    display: inline-block;
    text-decoration: none;
    background-color: #2d3748;
    border-bottom: 8px solid #2d3748;
    border-left: 18px solid #2d3748;
    border-right: 18px solid #2d3748;
    border-top: 8px solid #2d3748;">Վերականգնել Գաղտնաբառը</a>
</body>
</html>
<div style="margin:0;padding:0;width:100%!important">
    <table bgcolor="#edeff1" cellpadding="0" cellspacing="0" width="100%"
           style="background-color:#edeff1;border-collapse:collapse">
        <tbody>
        <tr>
            <td style="border-collapse:collapse;padding:40px 10px 40px 10px">
                <table align="center" cellpadding="0" cellspacing="0" width="600"
                       style="background-color:#ffffff;border:1px solid #edeff1;border-collapse:collapse">
                    <tbody>
                    @include('mail.header')
                    <tr style="background-color:#aeafaf">
                        <td style="border-collapse:collapse;padding:20px 30px 20px 30px"><h1
                                style="color:#fff;font-size:20px;font-weight:400;text-transform:uppercase">{{$header}}</h1>
                        </td>
                    </tr>
                    <tr style="font-family:'helvetica','arial',sans-serif;vertical-align:top">
                        <td align="left"
                            style="border-collapse:collapse;color:#333333;font-family:'helvetica','arial',sans-serif;font-size:16px;padding:5px">
                            &nbsp;
                        </td>
                        <td align="right"
                            style="border-collapse:collapse;color:#333333;font-family:'helvetica','arial',sans-serif;font-size:16px;padding:5px">
                            &nbsp;
                        </td>
                    </tr>
                    <tr><td style="border-collapse:collapse;padding:30px;color:#333333;font-family:Montserrat,sans-serif,Helvetica,Arial,sans-serif;font-size:16px">
                            {!!$text!!}<br><br>
                            <a href="{{$url}}" style="border-radius: 4px;
    color: #fff;
    display: inline-block;
    text-decoration: none;
    background-color: #2d3748;
    border-bottom: 8px solid #2d3748;
    border-left: 18px solid #2d3748;
    border-right: 18px solid #2d3748;
    border-top: 8px solid #2d3748;">Վերականգնել Գաղտնաբառը</a><br>
                            {{$url}}
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

