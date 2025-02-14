


<?php
// Load PHPMailer classes (adjust the paths as needed)
require 'PHPMailer/src/Exception.php';
require 'PHPMailer/src/PHPMailer.php';
require 'PHPMailer/src/SMTP.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

// Only process POST requests
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name           = htmlspecialchars($_POST['name'] ?? '');
    $email          = filter_var($_POST['email'] ?? '', FILTER_VALIDATE_EMAIL);
    $number         = htmlspecialchars($_POST['number'] ?? '');
    $subject        = htmlspecialchars($_POST['subject'] ?? 'No Subject');
    $messageContent = htmlspecialchars($_POST['message'] ?? '');
    $options        = htmlspecialchars($_POST['options'] ?? '');
    $contactMethod  = htmlspecialchars($_POST['contact_method'] ?? '');
    $subscribe      = isset($_POST['subscribe']) ? 'Yes' : 'No';

    // Validate email
    if (!$email) {
        exit('Invalid email address.');
    }

    // Build the email body
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
        $mail->Username   = 'your-email@gmail.com';      // Replace with your email
        $mail->Password   = 'your-app-password';           // Replace with your Gmail app password
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
        $mail->Port       = 587;

        // Recipients
        $mail->setFrom('your-email@gmail.com', 'Your Name');

        // Always send to admin
        $mail->addAddress('your-email@gmail.com', 'Your Name');

        // Also send a copy to the user's email (if it's not the same as admin)
        if ($email !== 'your-email@gmail.com') {
            $mail->addAddress($email);
        }

        // Email content
        $mail->isHTML(false);
        $mail->Subject = 'Contact Form Submission: ' . $subject;
        $mail->Body    = $body;

        $mail->send();
        echo 'Message sent successfully!';
    } catch (Exception $e) {
        echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
    }
} else {
    // If not a POST request, redirect to the form
    header('Location: contact.html');
    exit;
}
?>
