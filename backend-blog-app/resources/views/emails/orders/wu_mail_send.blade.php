

<p>
Thank you for your order!
STOP HERE AND READ NOW!  DO NOT GET BANNED!
YOU HAVE PLACED AN ORDER, YOU MUST SEND YOUR PAYMENT, OR EMAIL US AND
CANCEL NOW.
</p>

<p>
You have the name of the receiver(s) below.  Every receiver has first
name(s) and Last name(s).
</p>

<p>
SPELL THE NAMES PERFECTLY!!!
PAY ATTENTION TO DETAIL
</p>

<p>You have 12 hours to send the payment.</p>

<p>
Go to  WU, use the receiver name, Pay the amount ${{ $grandTotal }}.00
( WU will charge their fee in addition to this)
</p>

<p>
Return to the computer and send us the following info in this exact format:
Use your cell phone, take a pic of entire receipt
Put your order number in subject line
Email to us and we will ship your order to you as fast as possible.
</p>


<p>
RECEIVER FIRST NAME: {{ $moneyReceiver->first_name }}
</p>
@if($moneyReceiver->middle_name)
    <p>
        RECEIVER MIDDLE NAME: {{ $moneyReceiver->middle_name }}
    </p>
@endif
<p>
RECEIVER LAST NAME:  {{ $moneyReceiver->initial_name }}
</p>
<p>
LOCATION: {{ $moneyReceiver->country }}
</p>


<b><p style="font-size: 20px"><span style="font-size: 25px; color: red;">Notice:</span><br>You may escalate any customer service case by using our new TICKET system. <br>Click here <a href="{{ $domainName }}ticket">Ticket</a> or find TICKET in the site menu</p></b>


