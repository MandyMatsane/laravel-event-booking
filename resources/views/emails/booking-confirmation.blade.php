<!DOCTYPE html>
<html>
<head>
    <title>Booking Confirmation</title>
</head>
<body>
    <h1>Thank You for Your Booking!</h1>
    <p>Hello {{ $booking->user->name }},</p>
    <p>Your booking for the event <strong>{{ $booking->event->name }}</strong> has been successfully confirmed.</p>
    <p><strong>Booking Details:</strong></p>
    <ul>
        <li>Event: {{ $booking->event->name }}</li>
        <li>Date: {{ $booking->booking_date->format('d M Y') }}</li>
        <li>Location: {{ $booking->event->location }}</li>
    </ul>
    <p>We look forward to seeing you there!</p>

    <h3>QR Code</h3>
    <p>Here is your QR code for the event booking:</p>
    <img src="cid:qr_code.png" alt="QR Code">
</body>
</html>
