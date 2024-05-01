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
                    <tr>
                        <td style="border-collapse:collapse;color:#333333;font-family:'montserrat',sans-serif,'helvetica','arial',sans-serif;font-size:16px;padding:30px">
                            {!!$text!!}<br>&nbsp;
                            <table border="0"
                                   cellpadding="0"
                                   cellspacing="0"
                                   width="600"
                                   style="border-collapse:separate;font-family:'helvetica','arial',sans-serif">
                                <tbody>
                                <tr style="vertical-align:top">
                                    <td style="border-collapse:collapse;color:#333333;font-family:'montserrat',sans-serif,'helvetica','arial',sans-serif;font-size:16px;padding:5px"></td>
                                </tr>
                                <tr>
                                    <td style="border-collapse:collapse;color:#333333;font-family:'montserrat',sans-serif,'helvetica','arial',sans-serif;font-size:16px;padding:0px">
                                        <table border="0" cellpadding="0" cellspacing="0" width="100%"
                                               style="border-collapse:separate;border-top-color:#444;border-top-style:solid;border-top-width:3px;color:#444;font-family:'helvetica','arial',sans-serif">
                                            <tbody>
                                            <tr style="font-family:'helvetica','arial',sans-serif;font-size:14px;font-weight:400;text-align:center;text-transform:uppercase">
                                                <td style="border-bottom-color:#ebebeb;border-bottom-style:solid;border-bottom-width:1px;border-collapse:collapse;color:#333333;font-family:'helvetica','arial',sans-serif;font-size:16px;padding:10px 0px 10px 0px">
                                                    <table style="border-collapse:collapse">
                                                        <tbody>
                                                        @foreach($products as $product)
                                                            <tr>
                                                                <td style="border-collapse: collapse; color: #333333; font-family: 'helvetica', 'arial', sans-serif; font-size: 16px; padding: 5px 20px 5px 5px;">
                                                                    <img height="50" width="50" src="{{$product->product->general_image ? asset($product->product->general_image->image) : ''}}" style="text-decoration: none;" />
                                                                </td>
                                                                <td style="border-collapse: collapse; color: #333333; font-family: 'montserrat', sans-serif, 'helvetica', 'arial', sans-serif; font-size: 16px; padding: 5px; text-align: left; vertical-align: middle;">
                                                                    <span style="font-family: 'helvetica', 'arial', sans-serif;"><strong style="font-weight: 600;">{{$product->product->item_name}}</strong></span>
                                                                </td>
                                                                <td style="border-collapse: collapse; color: #333333; font-family: 'montserrat', sans-serif, 'helvetica', 'arial', sans-serif; font-size: 16px; padding: 5px; text-align: left; vertical-align: middle;">
                                                                    <span style="font-family: 'helvetica', 'arial', sans-serif;">
                                                                        <a
                                                                            href="{{route('site.product',$product->product->slug)}}"
                                                                            style="
                                                                                border-radius: 4px;
                                                                                color: #fff;
                                                                                display: inline-block;
                                                                                text-decoration: none;
                                                                                background-color: #2d3748;
                                                                                border-bottom: 8px solid #2d3748;
                                                                                border-left: 18px solid #2d3748;
                                                                                border-right: 18px solid #2d3748;
                                                                                border-top: 8px solid #2d3748;
                                                                            "
                                                                        >
                                                                            Գնահատել
                                                                        </a>
                                                                    </span>
                                                                </td>
                                                            </tr>

                                                        @endforeach
                                                        </tbody>
                                                    </table>
                                                </td>
                                            </tr>
                                            </tbody>
                                        </table>
                                    </td>
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


