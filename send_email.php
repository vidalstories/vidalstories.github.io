<?php
// Replace with your Mailgun API credentials
$api_key = 'YOUR_MAILGUN_API_KEY';
$domain = 'YOUR_MAILGUN_DOMAIN';

// Get form data
$name = $_POST['name'] ?? '';
$email = $_POST['email'] ?? '';
$message = $_POST['message'] ?? '';

// Validate input
if (empty($name) || empty($email) || empty($message)) {
    die('All fields are required.');
}

// Send email via Mailgun API
$url = "https://api.mailgun.net/v3/$domain/messages";
$ch = curl_init();

curl_setopt($ch, CURLOPT_URL, $url);
curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_BASIC);
curl_setopt($ch, CURLOPT_USERPWD, "api:$api_key");
curl_setopt($ch, CURLOPT_POST, true);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_POSTFIELDS, [
    'from'    => "Website Contact Form <no-reply@$domain>",
    'to'      => 'vidalstories@gmail.com',
    'subject' => "New Message from $name",
    'text'    => "Name: $name\nEmail: $email\n\nMessage:\n$message"
]);

$result = curl_exec($ch);
curl_close($ch);

// Success message
if ($result) {
    echo "Message sent successfully!";
} else {
    echo "Message sending failed.";
}
?>
