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

