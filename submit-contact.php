<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
// Start with PHPMailer class
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;

require_once './vendor/autoload.php';

use Dotenv\Dotenv;

// Load .env file
$dotenv = Dotenv::createImmutable(__DIR__);
$dotenv->load();
// require "db-connection.php";

// $stmt = $conn->prepare("INSERT INTO contact_us (name, email, phone, message, created_at) VALUES (?, ?, ?, ?, ?)");

// $stmt->bind_param("sssss", $username, $businessEmail, $phone, $message, $createdAt);

$username = $_POST['name'];
$email = $_POST['email'];
$phone = $_POST['phone'];
$subject = $_POST['subject'];
$message = $_POST['message'];
$createdAt = date('Y-m-d H:i:s');

$username = explode(' ', $username);
$firstName = $username[0];
$lastName = $username[1] ?? '';

// if ($stmt->execute()) {
//     echo json_encode(['status' => 'success', 'message' => "Thankyou for contacting us, our team will contact you"]);
// } else {
//     echo json_encode(['status' => 'error', 'message' => "Error Occurred, please try again later"]);
// }

// $stmt->close();
// $conn->close();



// create a new object
// $mail = new PHPMailer();
// configure an SMTP
// $mail->isSMTP();
// $mail->SMTPDebug = SMTP::DEBUG_SERVER;
// $mail->Host = $_ENV['MAIL_HOST'];
// $mail->SMTPAuth = true;
// $mail->Username = $_ENV['MAIL_USERNAME'];
// $mail->Password = $_ENV['MAIL_PASSWORD'];
// $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
// $mail->Port = $_ENV['MAIL_PORT'];

// $mail->setFrom($_ENV['MAIL_TO']);
// $mail->addAddress($_ENV['MAIL_TO']);
// $mail->Subject = $subject;
// Set HTML 
// $mail->isHTML(TRUE);
// $mail->Body = '<html>Hi,
//                         </br>
//                         </br>
//                         The following person has contacted us:
//                         </br>
//                         Name: ' . $username . '
//                         </br>
//                         Email: ' . $email . '
//                         </br>
//                         Phone: ' . $phone . '
//                         </br>
//                         Message: ' . $message . '  
//                     </html>';
// send the message
// if( $mail->send() ) {
//     echo json_encode(['status' => 'success', 'message' => 'Email has been sent successfully']);
// }


// Your Mailchimp API Key
$apiKey = $_ENV['MAIL_CHIMP_API_KEY'];

// Your Mailchimp Audience ID (List ID)
$listId = '7538ec374c';

// Mailchimp API URL
$dataCenter = substr($apiKey, strpos($apiKey, '-') + 1);  // Extract data center from API key
$url = 'https://' . $dataCenter . '.api.mailchimp.com/3.0/lists/' . $listId . '/members/';

if (!empty($email)) {
    // Data to send to Mailchimp API
    $data = [
        'email_address' => $email,
        'status' => 'subscribed',  // status: "subscribed", "unsubscribed", "cleaned", or "pending"
        'merge_fields' => [
            'FNAME' => $firstName,
            'LNAME' => $lastName,
            'PHONE' => $phone,
            'SUBJECT'=> $subject,
            'MESSAGE' => $message
        ]
    ];

    // Create a cURL session
    $ch = curl_init($url);

    // Set cURL options
    curl_setopt($ch, CURLOPT_USERPWD, 'user:' . $apiKey);
    curl_setopt($ch, CURLOPT_HTTPHEADER, ['Content-Type: application/json']);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_TIMEOUT, 10);
    curl_setopt($ch, CURLOPT_POST, true);
    curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));

    // Execute the cURL request
    $response = curl_exec($ch);
    $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);

    // Close the cURL session
    curl_close($ch);

    // Check if the request was successful
    if ($httpCode == 200) {
        echo json_encode(['message' => 'Successfully subscribed!']);
    } else {
        // Return error message if subscription fails
        $errorMessage = json_decode($response)->detail;
        echo json_encode(['message' => 'Subscription failed: ' . $errorMessage]);
    }
} else {
    echo json_encode(['message' => 'Email is required']);
}




