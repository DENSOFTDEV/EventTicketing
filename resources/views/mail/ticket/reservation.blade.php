@component('mail::message')
# Introduction

Hello {{$user->name}}.

You successfully reserved the following tickets for event:
{{$event->name}} happening {{$event->date}} at {{$event->venue}}


@component('mail::button', ['url' => $url])
Check Tickets Here
@endcomponent

@component('mail::table')
| #id           | Type          | price    | code    |
| ------------- |:-------------:| --------:|--------:|
@foreach($tickets as $ticket)
| {{$ticket->id}}      | {{$ticket->ticket_pricing->ticket->name}}     | {{$ticket->price}}      | {{$ticket->code}} |
@endforeach
@endcomponent

Thanks,<br>
{{ config('app.name') }}
@endcomponent
