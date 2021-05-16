@component('mail::message')


    # Welcome to {{ config('app.name') }}. Institution login information
    ##  Email: {{$data['email']}}
    ## Password: qwerty12345

    ##Please endeavour to change password upon login.

    @component('mail::button', ['url' => route('login')])
        Login
    @endcomponent


    Thanks,<br>
    {{ config('app.name') }}
@endcomponent
