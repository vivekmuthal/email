<?php
// Load PHPMailer if installed via Composer
// require __DIR__ . '/vendor/autoload.php';
require 'PHPMailer/src/Exception.php';
require 'PHPMailer/src/PHPMailer.php';
require 'PHPMailer/src/SMTP.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;


// Only process POST requests
if (isset($_POST['send'])) {
    $name          = htmlspecialchars($_POST['name'] ?? '');
    $email         = filter_var($_POST['email'] ?? '', FILTER_VALIDATE_EMAIL);
    $number        = htmlspecialchars($_POST['number'] ?? '');
    $subject       = htmlspecialchars($_POST['subject'] ?? 'No Subject');
    $messageContent= htmlspecialchars($_POST['message'] ?? '');
    $options       = htmlspecialchars($_POST['options'] ?? '');
    $contactMethod = htmlspecialchars($_POST['contact_method'] ?? '');
    $subscribe     = isset($_POST['subscribe']) ? 'Yes' : 'No';

    // Validate email
    if (!$email) {
        exit('Invalid email address.');
    }

    // Email body
    $body = "You have received a new contact form submission:\n\n";
    $body .= "Name: {$name}\n";
    $body .= "Email: {$email}\n";
    $body .= "Number: {$number}\n";
    $body .= "Subject: {$subject}\n";
    $body .= "Message: {$messageContent}\n";
    $body .= "Options: {$options}\n";
    $body .= "Preferred Contact Method: {$contactMethod}\n";
    $body .= "Subscribe: {$subscribe}\n";

    $mail = new PHPMailer(true);

    try {
        // SMTP settings
        $mail->isSMTP();
        $mail->Host       = 'smtp.gmail.com';
        $mail->SMTPAuth   = true;
        $mail->Username   = 'vivekmuthal07@gmail.com';  // Replace with your email
        $mail->Password   = 'kblc jrei jlfn olog';       // Replace with your Gmail app password
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
        $mail->Port       = 587;

        // Recipients
        $mail->setFrom('vivekmuthal07@gmail.com', 'RSB');  
        $mail->addAddress('vivekmuthal07@gmail.com', 'vivek'); 

        // Email content
        $mail->isHTML(false);
        $mail->Subject = 'Contact Form Submission: ' . $subject;
        $mail->Body    = $body;

        $mail->send();
        echo 'Message sent successfully!';
    } catch (Exception $e) {
        echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Contact Form</title>
</head>
<body>

<div class="container">
    <h2>Contact Us</h2>
    <form action="" method="post">
        <div>
            <label for="name">Name:</label>
            <input type="text" id="name" name="name" placeholder="Name" required>
        </div>
        <div>
            <label for="email">Email:</label>
            <input type="email" id="email" name="email" placeholder="Email" required>
        </div>
        <div>
            <label for="number">Number:</label>
            <input type="text" id="number" name="number" placeholder="Number">
        </div>
        <div>
            <label for="subject">Subject:</label>
            <input type="text" id="subject" name="subject" placeholder="Subject">
        </div>
        <div>
            <label for="message">Message:</label>
            <textarea id="message" name="message" placeholder="Your message"></textarea>
        </div>
        <div>
            <label for="options">Options:</label>
            <select id="options" name="options">
                <option value="option1">Option 1</option>
                <option value="option2">Option 2</option>
            </select>
        </div>
        <div>
            <input type="checkbox" id="subscribe" name="subscribe">
            <label for="subscribe">Subscribe</label>
        </div>
        <div>
            <label for="contact_method">Preferred Contact Method:</label>
            <select id="contact_method" name="contact_method">
                <option value="email">Email</option>
                <option value="phone">Phone</option>
            </select>
        </div>
        <button type="submit">Submit</button>
    </form>
</div>

</body>
</html>
