<p>
    Got a new ticket
    </p>
    
    <p>
    Hi,
    A new Ticket is created by 
    {{-- "{{ $ticket['user'] ? $ticket['user']['name'] : $ticket['name'] }}".  --}}
    "{{ $ticket['name'] }}". 
    The ticket details is here:
    </p>
    
    <p>
    Topic: {{ $ticket['topic'] }} {{ $ticket['order_number'] ? ' # Order Number '.$ticket['order_number'] : '' }} <br>
    Ticket Number: {{ $ticket['ticket_number'] }} <br>
    Created At: {{ $ticket['created_at'] }}
    </p>
    
    <p>
    Question: {{ $ticket['question'] }}
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
    Global Science <br>
    Email: info@theglobaldelta.com <br>
    Copyright © Global Science, All rights reserved.
    </p>
    