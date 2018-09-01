Hello {{$user->name}}

thank you for create for an account. please verify your email using this link:
{{ route('verify', $user->verification_token) }}