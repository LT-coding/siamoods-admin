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
                        <td style="border-collapse:collapse;padding:20px 30px">
                            <h2>Հարգելի {{$gift->recipient}},</h2>
                            <p style="font-size:16px;">նվեր քարտով կարող եք գնել Ձեր ընտրած զարդը մեր կայքից, մուտքագրելով կոդը պատվերի վճարման էջում։</p>
                            <p>{{$gift->message}}</p>
                        </td>
                    </tr>
                    <tr>
                        <td style="border-collapse:collapse; background-repeat: no-repeat;" background="{{asset('/images/gift_card_new.png')}}" width="500" height="320" valign="top">
                            <p style="color:black;font-size:18px;font-weight:bold;text-align:center;margin-top:190px;display:inline-block;margin-left:330px;padding:5px 10px;background: #fff;">{{$gift->unique_id}}</p>
                            <p style="color:#ff0049;font-size:20px;text-align:center;font-weight:bold;margin:0">{{$gift->amount}} ֏</p>
                        </td>
                    </tr>
                    <tr>
                        <td style="border-collapse:collapse;padding:20px 30px">
                            <a href="{{ config('app.url') }}" style="display:inline-block;margin-right:50px">SiaMoods.com</a>
                            <a href="{{ config('app.url') }}/gift-certificates">Ստուգել նվեր քարտը</a>
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
