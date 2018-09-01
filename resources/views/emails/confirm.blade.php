@component('mail::message')
    # Hello {{$user->name}}

    you changed your email, so we need to verify the new address. please use the button:


    @component('mail::button', ['url' =>  route('verify', $user->verification_token) ])
        Verify Account
    @endcomponent

    Thanks,<br>
    {{ config('app.name') }}
@endcomponent
