@component('mail::message')
Good Day Maam /Sir,<br><br>
<b>Your booking number</b> {{ $booking_code }} is approved by the Admin.<br>
<b>Date:</b> {{$date}}
<br>
<br>
<b>BOOKING DETAILS</b>
<br>
<hr>
<b>Departure Date:</b> {{ $departure_date }} <br>
<b>Pick Up Time:</b> {{ $pick_up_time }} <br>
<b>Routes:</b> {{ $origin }} -> {{ $destination }} <br>
<b>No. of Passengers:</b> {{ $passengers }}
<br>
<br>

Thank you!
@endcomponent