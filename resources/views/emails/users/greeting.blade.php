@component('mail::message')

    <h2>Dear {{ $name }},</h2>

    <p>Welcome to {{ config('app.name') }}! <br>Your account has been created with the following credentials:</p>

    <p>Email: <b>{{ $email }}</b><br>
        Password: <b>{{ $password }}</b></p>
    <p>For security, please change your password at your earliest convenience.
        <br>Log in using the provided credentials and update your password in the profile settings.</p>

    @component('mail::button', ['url' => $url])
        login
    @endcomponent

    <p>If you need assistance, contact us at {{ config('mail.support_email') }}.</p>

    <p>Best Regards,<br>{{ config('app.name') }}</p>

@endcomponent
