@component('mail::message')
# Hi {{ $user->name }},

We are very happy to have you here with us!
Please verify your email address using the button below:

@component('mail::button', ['url' => route('verify', $user->verification_token)])
Verify my email
@endcomponent

Thanks, <br>
{{ config('app.name') }}
@endcomponent