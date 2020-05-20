@component('mail::message')
# Welcome to the Community!

We all just wanted to let you know that you are a valued member of our work space. <br />
<br />
Go ahead and get something amazing acomplished!

@component('mail::button', ['url' => ''])
Go to your Dashboard
@endcomponent

Thanks,<br>
{{ config('app.name') }}
@endcomponent
