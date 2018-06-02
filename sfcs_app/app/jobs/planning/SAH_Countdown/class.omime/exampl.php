<?php

// Turn off all error reporting
error_reporting(0);
// Report simple running errors
error_reporting(E_ERROR | E_WARNING | E_PARSE);


// arvin castro
// http://sudocode.net/article/250/send-html-emails-with-embedded-inline-images-using-php
// November 28, 2010

include 'class.omime.php';

// Create omime object
$email = omime::create('related');

// Attach an image
$contentID = $email->addURL('hr.jpg', 'mimay.jpg');

// Create text message
$message = new omime('alternative');
//$message->attachText('This email has an email image [image: mimay.jpg] Ain\'t that neat?');
$message->attachHTML('This email has an email image <img src="cid:'.$contentID.'" alt="mimay.jpg" /> Ain\'t that neat?');

// Add message to email
$email->addMultipart($message);

// Send email
$successful = $email->send('brandixalerts@schemaxtech.com', 'test inline image', 'from: omime class <brandixalerts@schemaxtech.com>');

if($successful)
{
	echo "OK";
}
?>