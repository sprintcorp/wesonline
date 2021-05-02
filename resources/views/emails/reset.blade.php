@component('mail::message')


# Password reset link

@component('mail::button', ['url' => route('reset_link',$data['password_token'])])
Reset Password
@endcomponent

{{ route('reset_link',$data['password_token'])}}
Thanks,<br>
{{ config('app.name') }}
@endcomponent
