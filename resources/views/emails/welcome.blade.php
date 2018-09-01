@component('mail::message')
    # Hello {{$user->name}}

    thank you for create for an account. please verify your email using this link:


    @component('mail::button', ['url' =>  route('verify', $user->verification_token) ])
        Verify Account
    @endcomponent

    Thanks,<br>
    {{ config('app.name') }}
@endcomponent
