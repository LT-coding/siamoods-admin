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
                    <tr>
                        <td style="border-collapse:collapse;color:#333333;font-family:'montserrat',sans-serif,'helvetica','arial',sans-serif;font-size:16px;padding:30px">
                            {!!$messageText!!}:&nbsp;{{$review->product->item_name}}
                            <br><br>
                            <strong>Name</strong>:&nbsp;{{$review->name}}<br><strong>Գնահատական</strong>:&nbsp;{{$review->rating}}<br><strong>Message</strong>:<br>{{$review->review}}<br><br>View:<br><a
                                href="{{route('admin.reviews.index')}}"
                                rel="noopener noreferrer" style="color:#aeafaf" target="_blank"
                                >{{route('admin.reviews.index')}}</a></td>
                    </tr>
                    @include('mail.footer')
                    </tbody>
                </table>
            </td>
        </tr>
        </tbody>
    </table>
</div>
