<!DOCTYPE html>
<html>
<head>
    <title>New Contact Message</title>
</head>
<body>
    <h2>New Contact Message Received</h2>
    
    <p><strong>Name:</strong> {{ $contactMessage->name }}</p>
    <p><strong>Email:</strong> {{ $contactMessage->email }}</p>
    <p><strong>Subject:</strong> {{ $contactMessage->subject }}</p>
    
    <h3>Message:</h3>
    <p>{{ $contactMessage->message }}</p>
    
    <hr>
    <p><small>This message was sent from the contact form on the website.</small></p>
</body>
</html>