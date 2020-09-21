@component('mail::message')
# Hi {{ $user->name }},

Your email address has been changed!
Please verify your new email address using the button below:

@component('mail::button', ['url' => route('verify', $user->verification_token)])
Verify my email
@endcomponent

Thanks, <br>
{{ config('app.name') }}
@endcomponent