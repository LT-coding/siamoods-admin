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

