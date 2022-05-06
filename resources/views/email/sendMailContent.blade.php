@component('mail::message')

@component('mail::panel')
Topic: {{$topic}}
@endcomponent

@component('mail::panel')
Description: {{$content}}
@endcomponent


Thanks,<br>
Test
E-mail - testing@email<br>


@endcomponent