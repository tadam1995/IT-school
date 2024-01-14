<?php

use Util\Util as Util;
use Language\Language as Language;
use PHPMailer\Email as Email;


$_POST['data'] = '{"lang":{"id":"hu","type":"east"},"params":{"subject":"sasaassa","email":"odry.attila@keri.mako.hu","message":"sasasa"}}';

require_once('../../common/php/environment.php');

$args = Util::getArgs();

//$post_data = file_get_contents("php://input");
//$data = json_decode($post_data);

// Set language
$lang = new Language($args['lang']);

// Translate error messages
$errorMsg = $lang->translate(Email::$errorMessages);

// Set constants data
$constants = array(
	"{{lang_id}}" 					=> $args['lang']['id'],
	"{{current_date}}" 			=> date("Y-m-d"),
	"{{current_year}}" 			=> date("Y"),
	"{{message}}" 					=> $args['params']['message']
);

// Merge language with constants
$langData = array();
$langData = Util::objMerge($langData, $constants);

// Create email
$phpMailer = new Email($lang);

// Check is error
if ($phpMailer->isError()) {

	// Set error
	Util::setError("{$phpMailer->getErrorMsg()}!", $phpMailer, $lang);
}

// Set document
$phpMailer->setDocument(array(
	'fileName'		=> "contact.html",
	'subFolder' 	=> 'email'
), $constants, $langData);

// Close language
$lang = null;

try {

	// Add rest properties
  $phpMailer->Subject = $args['params']['subject'];
  $phpMailer->Body 		= $phpMailer->getDocument();
  $phpMailer->addAddress($args['params']['email']);

	// Send email
  $phpMailer->send();

// Exception
} catch (Exception $e) {

  // Set error
	Util::setError("{$errorMsg['email_send_failed']}!", $phpMailer);
}

// Close email
$phpMailer = null;

// Set response
Util::setResponse('email_send_successful');
