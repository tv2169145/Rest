Hello {{$user->name}}

you changed your email, so we need to verify the new address. please use the link:
{{ route('verify', $user->verification_token) }}