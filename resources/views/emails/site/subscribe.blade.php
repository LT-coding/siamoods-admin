@component('mail::message')

    <p>Thank you for subscribing to our newsletter! We're excited to have you on board.</p>

    <p>If you did not initiate this subscription, please ignore this email.</p>

    <p>If you need assistance, contact us at {{ config('mail.support_email') }}.</p>

    <p><small>If you wish to unsubscribe from our newsletter, you can do so by clicking on the following link: <a href="{{ $unsubscribeUrl }}">unsubscribe</a></small></p>

    <p>Best Regards,<br>{{ config('app.name') }}</p>

@endcomponent
