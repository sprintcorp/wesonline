@component('mail::message')


    # Welcome to {{ config('app.name') }}. Your login information
    ##  Email: {{$data['email']}}
    ## Password: qwerty12345

    @component('mail::button', ['url' => route('login')])
        Login
    @endcomponent


    Thanks,<br>
    {{ config('app.name') }}
@endcomponent
