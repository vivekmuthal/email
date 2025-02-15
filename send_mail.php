



<?php
// Load PHPMailer
require 'PHPMailer/src/Exception.php';
require 'PHPMailer/src/PHPMailer.php';
require 'PHPMailer/src/SMTP.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

// Only process POST requests
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    http_response_code(405);
    die('405 Method Not Allowed. Only POST requests are allowed.');
}

// Debugging: Check if POST data is received
if (empty($_POST)) {
    die('No form data received. Please check your form submission.');
}

// Sanitize input
$name          = trim(htmlspecialchars($_POST['name'] ?? ''));
$email         = filter_var(trim($_POST['email'] ?? ''), FILTER_VALIDATE_EMAIL);
$number        = trim(htmlspecialchars($_POST['number'] ?? ''));
$subject       = trim(htmlspecialchars($_POST['subject'] ?? 'No Subject'));
$messageContent= trim(htmlspecialchars($_POST['message'] ?? ''));
$options       = trim(htmlspecialchars($_POST['options'] ?? ''));
$contactMethod = trim(htmlspecialchars($_POST['contact_method'] ?? ''));
$subscribe     = isset($_POST['subscribe']) ? 'Yes' : 'No';

// Validate email
if (!$email) {
    die('Invalid email address.');
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
    $mail->Username   = 'vivekmuthal07@gmail.com';  // Replace with your Gmail
    $mail->Password   = 'kblc jrei jlfn olog';    // Replace with your Gmail App Password
    $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
    $mail->Port       = 587;

    // Recipients
    $mail->setFrom('vivekmuthal07@gmail.com', 'vivek');  
    $mail->addAddress('vivekmuthal07@gmail.com', 'Recipient Name'); 

    // Email content
    $mail->isHTML(false);
    $mail->Subject = 'Contact Form Submission: ' . $subject;
    $mail->Body    = $body;

    // Send email
    if ($mail->send()) {
        echo 'Message sent successfully!';
    } else {
        echo 'Message could not be sent. Please try again later.';
    }
} catch (Exception $e) {
    echo "Mailer Error: {$mail->ErrorInfo}";
}
?>
