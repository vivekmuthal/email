<?php
// Enable CORS for debugging
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: POST, GET, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type");

// Allow only POST requests
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    http_response_code(405);
    exit('405 Method Not Allowed');
}

// Load PHPMailer
require 'PHPMailer/src/Exception.php';
require 'PHPMailer/src/PHPMailer.php';
require 'PHPMailer/src/SMTP.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

// Check if form was submitted
if (isset($_POST['submit'])) {
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
        $mail->Username   = 'vivekmuthal07@gmail.com';  // Your email
        $mail->Password   = 'kblc jrei jlfn olog';       // Your Gmail app password
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
