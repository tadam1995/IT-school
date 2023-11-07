<?php


$post_data = file_get_contents("php://input");
$data = json_decode($post_data);



//email information
$to = "dgera90x@gmail.com";

$subject = $data['subject'];
$userEmail=$data['email'];
$message=$data['message'];



$headers = 'From: ' . $userEmail . "\r\n" .
        'Reply-To:'.$userEmail . "\r\n" .
        'X-Mailer: PHP/' . phpversion();

//php mail function to send email on your email address
mail($to, $subject, $message, $headers);

//Email response
  echo "Thank you for contacting us!";


?>