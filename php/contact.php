<?php

use Util\Util as Util;
use Language\Language as Language;
use PHPMailer\Email as Email;

require_once('../../common/php/environment.php');

$args = Util::getArgs();

// Set language
$lang = new Language($args['lang']);

// Translate error messages
$errorMsg = $lang->translate(Email::$errorMessages);

$langData = $lang->translate(array(
	"{{confirmation}}"	=> "confirmation",
	"{{returnText}}"	=> "returnText",
	"{{yourMessage}}"   => "yourMessage",
	"{{school}}"        => "school"
));

// Set constants data
$constants = array(
	"{{lang_id}}" 					=> $args['lang']['id'],
	"{{current_date}}" 			=> date('Y/m/d H:i:s'),
	"{{current_year}}" 			=> date("Y"),
	"{{message}}" 					=> $args['params']['message'],
	"{{email}}"                   => $args['params']['email'],
	"{{fromName}}"                => $args['params']['name']
);

// Merge language with constants
$langData = array();
$langData = Util::objMerge($langData, $constants);

// Create email
$phpMailerUser = new Email($lang);
$phpMailerSchool = new Email($lang);


// Check is error
if ($phpMailerUser->isError()) {

	// Set error
	Util::setError("{$phpMailerUser->getErrorMsg()}!", $phpMailerUser, $lang);
}

// Visszaigazolás az email elküldéséről

$phpMailerUser->setDocument(array(
	'fileName'		=> "contactUser.html",
	'subFolder' 	=> 'email'
), $constants, $langData);

// Az iskola részére küldött email

$phpMailerSchool->setDocument(array(
	'fileName'		=> "contactSchool.html",
	'subFolder' 	=> 'email'
), $constants, $langData);

// Close language
$lang = null;

try {

	// Az email tartalma

  $phpMailerSchool->FromName = $args['params']['name'];
  $phpMailerUser->Subject = $args['params']['subject'];
  $phpMailerSchool->Subject = $args['params']['subject'];
  $phpMailerUser->Body 		= $phpMailerUser->getDocument();
  $phpMailerSchool->Body 		= $phpMailerSchool->getDocument();
  $phpMailerUser->addAddress($args['params']['email']);
  $phpMailerSchool->addAddress('jakabhunorszki@gmail.com');
  $phpMailerUser->isHTML(true);


	// Send email
  $phpMailerUser->send();
  $phpMailerSchool->send();


// Exception
} catch (Exception $e) {

  // Set error
	Util::setError("{$errorMsg['email_send_failed']}!", $phpMailerUser);
}

// Close email
$phpMailerUser = null;
$phpMailerSchool = null;


// Set response
Util::setResponse('email_send_successful');
