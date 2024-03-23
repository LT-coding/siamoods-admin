@component('mail::message')

    <h2>New message from {{ $name }} ({{ $email }}).</h2>

    <p>{{ $message }}</p>

    <p>Best Regards,<br>{{ config('app.name') }}</p>

@endcomponent
