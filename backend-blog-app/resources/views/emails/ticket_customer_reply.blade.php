<p>
Got a new Reply
</p>

<p>
Hi,
A new Reply is created by 
{{-- "{{ $ticket['user'] ? $ticket['user']->name : $ticket['name'] }}".  --}}
"{{ $ticket['name'] }}". 
The ticket details is here:
</p>

<p>
Topic: {{ $ticket['topic'] }} {{ $ticket['order_number']?' # Order Number '.$ticket['order_number'] : '' }} <br>
Ticket Number: {{ $ticket['ticket_number'] }} <br>
Created At: {{ $ticket['created_at'] }}
</p>

<p>
Reply:
{{ $ticket['reply'] }}
</p>

<p>
To view the ticket or add reply, please click the button below
</p>

<p>
<a href="{{ route('admin.tickets.reply',$ticket['id']) }}">View Ticket</a>
<br>
or paste this into your browser:
</p>

<p>
<a href="{{ route('admin.tickets.reply',$ticket['id']) }}">{{ route('admin.tickets.reply',$ticket['id']) }}</a>
</p>

<p>
Monster Lab <br>
Email: info@monsterlab.com <br>
Copyright © Monster Lab, All rights reserved.
</p>
