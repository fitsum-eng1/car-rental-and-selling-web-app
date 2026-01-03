@component('mail::message')
# Secure Payment Link

Hello {{ $booking->user->name }},

We have generated a secure payment link for your booking.

## Booking Details

**Booking ID:** {{ $booking->id }}  
**Vehicle:** {{ $booking->vehicle->make }} {{ $booking->vehicle->model }}  
**Pickup Date:** {{ $booking->pickup_date->format('M d, Y') }}  
**Return Date:** {{ $booking->return_date->format('M d, Y') }}  
**Total Amount:** ${{ number_format($booking->total_amount, 2) }}

@component('mail::panel')
**Important:** This payment link will expire on {{ $expiresAt->format('M d, Y \a\t g:i A') }}.
@endcomponent

@component('mail::button', ['url' => $paymentLink])
Complete Payment Securely
@endcomponent

For your security, this link is unique to your booking and will expire after 48 hours.

If you have any questions or need assistance, please contact our support team.

Thanks,<br>
{{ config('app.name') }} Team
@endcomponent