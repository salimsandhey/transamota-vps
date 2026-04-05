<!DOCTYPE html>
<html>
<head>
    <title>New Contact Message</title>
</head>
<body>
    <h2>New Contact Message Received</h2>
    
    <p><strong>Name:</strong> <?php echo e($contactMessage->name); ?></p>
    <p><strong>Email:</strong> <?php echo e($contactMessage->email); ?></p>
    <p><strong>Subject:</strong> <?php echo e($contactMessage->subject); ?></p>
    
    <h3>Message:</h3>
    <p><?php echo e($contactMessage->message); ?></p>
    
    <hr>
    <p><small>This message was sent from the contact form on the website.</small></p>
</body>
</html><?php /**PATH /var/www/transamota.com/resources/views/emails/contact-message.blade.php ENDPATH**/ ?>