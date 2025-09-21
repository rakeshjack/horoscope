<?php
// Simple sanitization function
function clean_input($data) {
  return htmlspecialchars(stripslashes(trim($data)));
}

// Check if POST data exists
if ($_SERVER["REQUEST_METHOD"] == "POST") {
  // Get and sanitize inputs
  $name     = clean_input($_POST['bb_name'] ?? '');
  $phone    = clean_input($_POST['bb_phone'] ?? '');
  $email    = clean_input($_POST['bb_email'] ?? '');
  $location = clean_input($_POST['bb_location'] ?? '');
  $message  = clean_input($_POST['bb_message'] ?? '');

  // Validate required fields
  if (empty($name) || empty($phone) || empty($email) || empty($message)) {
    http_response_code(400);
    echo "Please fill all required fields.";
    exit;
  }

  // Email details
  $to = "srimahasivanadijothidam@gmail.com"; // Replace with your email
  $subject = "New Contact Form Submission for NadiJoshiyam";
  $body = "Name: $name\nPhone: $phone\nEmail: $email\nLocation: $location\nMessage:\n$message";
  $headers = "From: $email\r\nReply-To: $email";

  // Send email
  if (mail($to, $subject, $body, $headers)) {
    echo "Message sent successfully!";
  } else {
    http_response_code(500);
    echo "Failed to send email. Please try again.";
  }
} else {
  http_response_code(403);
  echo "Forbidden.";
}

?>