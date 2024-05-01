<div style="margin: 0; padding: 0; width: 100% !important;">
    <table bgcolor="#edeff1" cellpadding="0" cellspacing="0" width="100%" style="background-color: #edeff1; border-collapse: collapse;">
        <tbody>
        <tr>
            <td style="border-collapse: collapse; padding: 40px 10px 40px 10px;">
                <table align="center" cellpadding="0" cellspacing="0" width="600" style="background-color: #ffffff; border: 1px solid #edeff1; border-collapse: collapse;">
                    <tbody>
                    @include('mail.header')
                    <tr style="background-color: #aeafaf;">
                        <td style="border-collapse: collapse; padding: 20px 30px 20px 30px;"><h1 style="color: #fff; font-size: 20px; font-weight: 400; text-transform: uppercase;">{{$header}}</h1></td>
                    </tr>
                    <tr style="font-family: 'helvetica', 'arial', sans-serif; vertical-align: top;">
                        <td align="left" style="border-collapse: collapse; color: #333333; font-family: 'helvetica', 'arial', sans-serif; font-size: 16px; padding: 5px;">
                            &nbsp;
                        </td>
                        <td align="right" style="border-collapse: collapse; color: #333333; font-family: 'helvetica', 'arial', sans-serif; font-size: 16px; padding: 5px;">
                            &nbsp;
                        </td>
                    </tr>
                    <tr>
                        <td style="border-collapse: collapse; color: #333333; font-family: 'montserrat', sans-serif, 'helvetica', 'arial', sans-serif; font-size: 16px; padding: 30px;">
                            {!!$text!!}<br />
                            @if($notification->type == \App\Models\Notification::WAITING_ORDER_7 || $notification->type == \App\Models\Notification::WAITING_ORDER_2)
                                <a href="{{route('site.checkout')}}"
                                   style="border-radius: 4px;
                                color: #fff;
                                margin-top: 10px;
                                display: inline-block;
                                text-decoration: none;
                                background-color: #2d3748;
                                border-bottom: 8px solid #2d3748;
                                border-left: 18px solid #2d3748;
                                border-right: 18px solid #2d3748;
                                border-top: 8px solid #2d3748;">Ավարտել պատվերը</a>
                            @endif
                            &nbsp;
                            <table border="0" cellpadding="0" cellspacing="0" width="600" style="border-collapse: separate; font-family: 'helvetica', 'arial', sans-serif;">
                                <tbody>
                                <tr style="vertical-align: top;">
                                    <td style="border-collapse: collapse; color: #333333; font-family: 'montserrat', sans-serif, 'helvetica', 'arial', sans-serif; font-size: 16px; padding: 5px;">
                                        <table border="0" cellspacing="0" style="border-collapse: separate; font-family: 'helvetica', 'arial', sans-serif;">
                                            <tbody>
                                            <tr>
                                                <td
                                                    width="50%"
                                                    style="border-collapse: collapse; color: #333333; font-family: 'helvetica', 'arial', sans-serif; font-size: 16px; padding: 0px 40px 10px 0px; vertical-align: top;"
                                                >
                                                    <h2 style="color: #444444; font-family: 'helvetica', 'arial', sans-serif; font-size: 22px; line-height: 1.5em; margin: 0px 0px 15px 0px; text-transform: uppercase;">
                                                        Առաքման տվյալներ
                                                    </h2>
                                                    <p style="font-family: 'helvetica', 'arial', sans-serif; font-size: 14px; margin: 0px; padding-bottom: 5px;">
                                                        <strong>{{$order['order']->user->shippingAddress->name}} {{$order['order']->user->shippingAddress->lastname}}</strong>
                                                    </p>
                                                    <p style="font-family: 'helvetica', 'arial', sans-serif; font-size: 14px; margin: 0px; padding-bottom: 5px;">
                                                        {{$order['order']->user->shippingAddress->address_1}}
                                                    </p>
                                                    <p style="font-family: 'helvetica', 'arial', sans-serif; font-size: 14px; margin: 0px; padding-bottom: 5px;">
                                                        {{$order['order']->user->shippingAddress->city}}
                                                    </p>
                                                    <p style="font-family: 'helvetica', 'arial', sans-serif; font-size: 14px; margin: 0px; padding-bottom: 5px;">
                                                        Հայաստան
                                                    </p>
                                                    <p style="font-family: 'helvetica', 'arial', sans-serif; font-size: 14px; margin: 0px; padding-bottom: 5px;">
                                                        {{$order['order']->user->shippingAddress->phone}}
                                                    </p>
                                                </td>
                                                <td
                                                    width="50%"
                                                    style="border-collapse: collapse; color: #333333; font-family: 'helvetica', 'arial', sans-serif; font-size: 16px; padding: 0px 0px 10px 40px; vertical-align: top;"
                                                >
                                                    <p style="color: #787878; font-family: 'helvetica', 'arial', sans-serif; font-size: 14px; margin: 0px; padding-bottom: 5px;">
                                                        <span style="color: #444444; font-family: 'helvetica', 'arial', sans-serif; font-weight: 600; text-transform: uppercase;">Պատվերի ամսաթիվ</span>
                                                        {{\Carbon\Carbon::now()->format('d/m/Y, H:i')}}
                                                    </p>
                                                    <p style="color: #787878; font-family: 'helvetica', 'arial', sans-serif; font-size: 14px; margin: 0px; padding-bottom: 5px;">
                                                        <span style="color: #444444; font-family: 'helvetica', 'arial', sans-serif; font-weight: 600; text-transform: uppercase;">Վճարում</span>
                                                        @php $payment = \App\Models\Payments::find($order['order']->payment_id); $title = $payment?$payment->title:''; @endphp {{$title}}
                                                    </p>
                                                    <p style="color: #787878; font-family: 'helvetica', 'arial', sans-serif; font-size: 14px; margin: 0px; padding-bottom: 5px;">
                                                        <span style="color: #444444; font-family: 'helvetica', 'arial', sans-serif; font-weight: 600; text-transform: uppercase;">Առաքում</span>
                                                        {{ \App\Models\ShippingType::find($order['order']->shipping_type_id)?->name }}
                                                    </p>
                                                </td>
                                            </tr>
                                            </tbody>
                                        </table>
                                    </td>
                                </tr>
                                <tr>
                                    <td style="border-collapse: collapse; color: #333333; font-family: 'montserrat', sans-serif, 'helvetica', 'arial', sans-serif; font-size: 16px; padding: 0px;">
                                        <table
                                            border="0"
                                            cellpadding="0"
                                            cellspacing="0"
                                            width="100%"
                                            style="border-collapse: separate; border-top-color: #444; border-top-style: solid; border-top-width: 3px; color: #444; font-family: 'helvetica', 'arial', sans-serif;"
                                        >
                                            <tbody>
                                            <tr style="font-family: 'helvetica', 'arial', sans-serif; font-size: 12px; font-weight: 600; text-align: center; text-transform: uppercase;">
                                                <td style="border-collapse: collapse; color: #333333; font-family: 'helvetica', 'arial', sans-serif; font-size: 16px; padding: 10px;">
                                                    Նկարագրություն
                                                </td>
                                                <td style="border-collapse: collapse; color: #333333; font-family: 'helvetica', 'arial', sans-serif; font-size: 16px; padding: 10px;">
                                                    Քանակ
                                                </td>
                                                <td style="border-collapse: collapse; color: #333333; font-family: 'helvetica', 'arial', sans-serif; font-size: 16px; padding: 10px;">
                                                    Միավորի արժեք
                                                </td>
                                                <td style="border-collapse: collapse; color: #333333; font-family: 'helvetica', 'arial', sans-serif; font-size: 16px; padding: 10px;">
                                                    Արժեք
                                                </td>
                                            </tr>
                                            @foreach($order['cart'] as $cart)
                                                <tr style="font-family: 'helvetica', 'arial', sans-serif; font-size: 14px; font-weight: 400; text-align: center; text-transform: uppercase;">
                                                    <td style="border-bottom-color: #ebebeb; border-bottom-style: solid; border-bottom-width: 1px; border-collapse: collapse; color: #333333; font-family: 'helvetica', 'arial', sans-serif; font-size: 16px; padding: 10px 0px 10px 0px;">
                                                        <table style="border-collapse: collapse;">
                                                            <tbody>
                                                            <tr>
                                                                <td rowspan="2" style="border-collapse: collapse; color: #333333; font-family: 'helvetica', 'arial', sans-serif; font-size: 16px; padding: 5px 20px 5px 5px;">
                                                                    <img height="50" width="50" src="{{$cart['product']->general_image ? asset($cart['product']->general_image->image) : ''}}" style="text-decoration: none;" />
                                                                </td>

                                                                <td style="border-collapse: collapse; color: #333333; font-family: 'montserrat', sans-serif, 'helvetica', 'arial', sans-serif; font-size: 16px; padding: 5px; text-align: left; vertical-align: middle;">
                                                                    <span style="font-family: 'helvetica', 'arial', sans-serif;"><strong style="font-weight: 600;">{{$cart['product']->item_name}}</strong></span>
                                                                </td>
                                                            </tr>
                                                            <tr>
                                                                <td style="border-collapse: collapse; color: #333333; font-family: 'helvetica', 'arial', sans-serif; font-size: 16px; padding: 5px; text-align: left; vertical-align: top;">
                                                                    &nbsp;
                                                                </td>
                                                            </tr>
                                                            </tbody>
                                                        </table>
                                                    </td>
                                                    <td style="border-bottom-color: #ebebeb; border-bottom-style: solid; border-bottom-width: 1px; border-collapse: collapse; color: #333333; font-family: 'helvetica', 'arial', sans-serif; font-size: 16px; padding: 10px 0px 10px 0px;">
                                                        <p style="font-family: 'helvetica', 'arial', sans-serif; margin: 1em 0 1em 0; text-align: center;">
                                                            <strong style="font-weight: 600;">{{$cart['quantity']}}</strong>
                                                        </p>
                                                    </td>
                                                    <td style="border-bottom-color: #ebebeb; border-bottom-style: solid; border-bottom-width: 1px; border-collapse: collapse; color: #333333; font-family: 'helvetica', 'arial', sans-serif; font-size: 16px; padding: 10px 0px 10px 0px;">
                                                        <p style="font-family: 'helvetica', 'arial', sans-serif; margin: 1em 0 1em 0; text-align: center;">
                                                            <strong style="font-weight: 600;">{{$cart['promoPrice']}} &nbsp;֏</strong>
                                                        </p>
                                                    </td>
                                                    <td style="border-bottom-color: #ebebeb; border-bottom-style: solid; border-bottom-width: 1px; border-collapse: collapse; color: #333333; font-family: 'helvetica', 'arial', sans-serif; font-size: 16px; padding: 10px 0px 10px 0px;">
                                                        <p style="font-family: 'helvetica', 'arial', sans-serif; margin: 1em 0 1em 0; text-align: center;">
                                                            <strong style="font-weight: 600;">{{$cart['priceTotal']}} &nbsp;֏</strong>
                                                        </p>
                                                    </td>
                                                </tr>
                                            @endforeach
                                            </tbody>
                                        </table>
                                    </td>
                                </tr>
                                <tr>
                                    <td
                                        style="
                                                        border-collapse: collapse;
                                                        border-top-color: #f5f5f5;
                                                        border-top-style: solid;
                                                        border-top-width: 2px;
                                                        color: #333333;
                                                        font-family: 'helvetica', 'arial', sans-serif;
                                                        font-size: 16px;
                                                        padding: 10px 0px 0px 0px;
                                                    "
                                    >
                                        <table width="100%" style="border-collapse: separate; font-family: 'helvetica', 'arial', sans-serif;">
                                            <tbody>
                                            <tr>
                                                <td
                                                    width="66%"
                                                    style="
                                                                        border-collapse: collapse;
                                                                        color: #444444;
                                                                        font-family: 'helvetica', 'arial', sans-serif;
                                                                        font-size: 14px;
                                                                        line-height: 21px;
                                                                        padding: 5px 30px 5px 5px;
                                                                        vertical-align: top;
                                                                    "
                                                >
                                                    @if($order['order']->comment)
                                                        <h2
                                                            style="
                                                                            border-bottom-color: #e8e8e8;
                                                                            border-bottom-style: solid;
                                                                            border-bottom-width: 3px;
                                                                            color: #444444;
                                                                            font-family: 'helvetica', 'arial', sans-serif;
                                                                            font-size: 22px;
                                                                            margin: 0px 0px 10px 0px;
                                                                            padding-bottom: 20px;
                                                                            text-transform: uppercase;
                                                                        "
                                                        >
                                                            Հաճախորդի նշումներ
                                                        </h2>
                                                        {{ $order['order']->comment }} @endif
                                                </td>
                                                <td width="34%" style="border-collapse: collapse; color: #333333; font-family: 'helvetica', 'arial', sans-serif; font-size: 16px; padding: 5px; vertical-align: top;">
                                                    <table style="border-collapse: collapse; color: #444; font-family: 'helvetica', 'arial', sans-serif; font-size: 14px;">
                                                        <tbody>
                                                        <tr style="font-family: 'helvetica', 'arial', sans-serif; vertical-align: top;">
                                                            <td align="left" style="border-collapse: collapse; color: #333333; font-family: 'helvetica', 'arial', sans-serif; font-size: 16px; padding: 5px 5px 20px 5px;">
                                                                Ընդհանուր
                                                            </td>
                                                            <td align="right" style="border-collapse: collapse; color: #333333; font-family: 'helvetica', 'arial', sans-serif; font-size: 16px; padding: 5px;">
                                                                {{$order['total']}}&nbsp;֏
                                                            </td>
                                                        </tr>
                                                        <tr style="vertical-align: top;">
                                                            <td
                                                                align="left"
                                                                style="
                                                                                        border-collapse: collapse;
                                                                                        color: #333333;
                                                                                        font-family: 'helvetica', 'arial', sans-serif;
                                                                                        font-size: 16px;
                                                                                        padding: 5px 5px 20px 5px;
                                                                                        text-transform: uppercase;
                                                                                    "
                                                            >
                                                                &nbsp;
                                                            </td>
                                                            <td align="right" style="border-collapse: collapse; color: #333333; font-family: 'helvetica', 'arial', sans-serif; font-size: 16px; padding: 5px;">
                                                                &nbsp;
                                                            </td>
                                                        </tr>
                                                        @if( $order['rateTotal'] - $order['total'] > 0)
                                                            <tr style="vertical-align: top;">
                                                                <td align="left" style="border-collapse: collapse; color: #333333; font-family: 'helvetica', 'arial', sans-serif; font-size: 16px; padding: 5px 5px 20px 5px;">
                                                                    Առաքում
                                                                </td>
                                                                <td align="right" style="border-collapse: collapse; color: #333333; font-family: 'helvetica', 'arial', sans-serif; font-size: 16px; padding: 5px;">
                                                                    {{$order['rateTotal'] - $order['total']}}&nbsp;֏
                                                                </td>
                                                            </tr>
                                                        @endif
                                                        <tr style="font-family: 'helvetica', 'arial', sans-serif; vertical-align: top;">
                                                            <td align="left" style="border-collapse: collapse; color: #333333; font-family: 'helvetica', 'arial', sans-serif; font-size: 16px; padding: 5px;">
                                                                &nbsp;
                                                            </td>
                                                            <td align="right" style="border-collapse: collapse; color: #333333; font-family: 'helvetica', 'arial', sans-serif; font-size: 16px; padding: 5px;">
                                                                &nbsp;
                                                            </td>
                                                        </tr>
                                                        <tr style="font-family: 'helvetica', 'arial', sans-serif; vertical-align: top;">
                                                            <td align="left" style="border-collapse: collapse; color: #333333; font-family: 'helvetica', 'arial', sans-serif; font-size: 16px; padding: 5px;">
                                                                &nbsp;
                                                            </td>
                                                            <td align="right" style="border-collapse: collapse; color: #333333; font-family: 'helvetica', 'arial', sans-serif; font-size: 16px; padding: 5px;">
                                                                &nbsp;
                                                            </td>
                                                        </tr>
                                                        <tr style="font-family: 'helvetica', 'arial', sans-serif; vertical-align: top;">
                                                            <td align="left" style="border-collapse: collapse; color: #333333; font-family: 'helvetica', 'arial', sans-serif; font-size: 16px; padding: 5px;">
                                                                &nbsp;
                                                            </td>
                                                            <td align="right" style="border-collapse: collapse; color: #333333; font-family: 'helvetica', 'arial', sans-serif; font-size: 16px; padding: 5px;">
                                                                &nbsp;
                                                            </td>
                                                        </tr>
                                                        <tr style="font-family: 'helvetica', 'arial', sans-serif; font-size: 22px; font-weight: 600; vertical-align: top;">
                                                            <td
                                                                align="left"
                                                                style="
                                                                                        border-collapse: collapse;
                                                                                        border-top-color: #e8e8e8;
                                                                                        border-top-style: solid;
                                                                                        border-top-width: 1px;
                                                                                        color: #333333;
                                                                                        font-family: 'helvetica', 'arial', sans-serif;
                                                                                        font-size: 22px;
                                                                                        padding: 20px 5px 5px 5px;
                                                                                    "
                                                            >
                                                                Ընդամենը
                                                            </td>
                                                            <td
                                                                align="right"
                                                                style="
                                                                                        border-collapse: collapse;
                                                                                        border-top-color: #e8e8e8;
                                                                                        border-top-style: solid;
                                                                                        border-top-width: 1px;
                                                                                        color: #333333;
                                                                                        font-family: 'helvetica', 'arial', sans-serif;
                                                                                        font-size: 22px;
                                                                                        padding: 20px 5px 5px 5px;
                                                                                    "
                                                            >
                                                                {{$order['rateTotal']}}&nbsp;֏
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
