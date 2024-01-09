<?php

use Util\Util as Util;
use Database\Database as Database;
use Language\Language as Language;
use PHPMailer\Email as Email;

require_once('../../../common/php/environment.php');

$args = Util::getArgs();

//$post_data = file_get_contents("php://input");
//$data = json_decode($post_data);


// Create email
$phpMailer = new Email();

// Check is error
if ($phpMailer->isError()) {

	// Set error
	Util::setError("{$phpMailer->getErrorMsg()}!
									\n{$message}", $phpMailer);
}



// Check is error
if ($phpMailer->isError()) {

	// Set error
	Util::setError("{$phpMailer->getErrorMsg()}!
									\n{$message}", $phpMailer);
}

try {

	// Add rest properties
  $phpMailer->Subject = $args.['subject'];
  $phpMailer->Body 		= "asdasd";
  $phpMailer->addAddress($args['user']['email_current']);

	// Send email
  $phpMailer->send();

// Exception
} catch (Exception $e) {

  // Set error
	Util::setError("{$errorMsg['email_send_failed']}!
									\n{$message}", $phpMailer);
}

// Clear all addresses to
$phpMailer->clearToAddresses();


// Check is error
if ($phpMailer->isError()) {

	// Set error
	Util::setError("{$phpMailer->getErrorMsg()}!
									\n{$message}", $phpMailer);
}

try {

	// Add rest properties
  //$phpMailer->Body = $phpMailer->getDocument();
	//$phpMailer->addAddress($args['user']['email']);

	// Send email
  $phpMailer->send();

// Exception
} catch (Exception $e) {

  // Set error
	Util::setError("{$errorMsg['email_send_failed']}!
									\n{$message}", $phpMailer);
}

// Close email
$phpMailer = null;

// Set response
Util::setResponse('message_sent');