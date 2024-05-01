<div>
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
                                    style="color:#fff;font-size:20px;font-weight:400;text-transform:uppercase">Low
                                    inventory of "{{$name}}"</h1></td>
                        </tr>
                        <tr>
                            <td style="border-collapse:collapse;color:#333333;font-family:'montserrat',sans-serif,'helvetica','arial',sans-serif;font-size:16px;padding:30px">
                                <table style="border-collapse:collapse">
                                    <tbody>
                                    <tr>
                                        <td style="border-collapse:collapse;color:#333333;font-family:'montserrat',sans-serif,'helvetica','arial',sans-serif;font-size:16px;padding:5px">
                                            Ապրանք:
                                        </td>
                                        <td style="border-collapse:collapse;color:#333333;font-family:'montserrat',sans-serif,'helvetica','arial',sans-serif;font-size:16px;padding:5px">
                                            {{$name}}
                                        </td>
                                    </tr>
                                    <tr>
                                        <td style="border-collapse:collapse;color:#333333;font-family:'montserrat',sans-serif,'helvetica','arial',sans-serif;font-size:16px;padding:5px">
                                            Քանակ:
                                        </td>
                                        <td style="border-collapse:collapse;color:#333333;font-family:'montserrat',sans-serif,'helvetica','arial',sans-serif;font-size:16px;padding:5px">
                                            <strong>0</strong></td>
                                    </tr>
                                    </tbody>
                                </table>
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
</div>
