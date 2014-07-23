<?php

require __DIR__.'/../vendor/autoload.php';


extract($_POST);

// Set your admin email here 
$ADMIN_EMAIL = 'gustavosf@gmail.com';

// Set up Mandrill credentials
$MANDRILL_USERNAME = 'beirariogps@gmail.com';
$MANDRILL_PASSWORD = 'n-ez6lZeFIy5ZFe7HYH10A';

// Check if email is valid 
if ( validEmail($email) ) {
	
	/*
	// send mail
	$headers = "From: " . strip_tags($email) . "\r\n";
	$headers .= "Reply-To: ". strip_tags($email) . "\r\n";
	$headers .= "MIME-Version: 1.0\r\n";
	$headers .= "Content-Type: text/html; charset=ISO-8859-1\r\n";
	
	$message = 'Message from: '.$name.': <br><br>'.$message;
	mail($ADMIN_EMAIL, 'Message sent from '.$name.'', $message, $headers);
	*/

	$transport = Swift_SmtpTransport::newInstance('smtp.mandrillapp.com', 587);
	$transport->setUsername($MANDRILL_USERNAME);
	$transport->setPassword($MANDRILL_PASSWORD);

	$message = Swift_Message::newInstance();
	$message->setTo($ADMIN_EMAIL);
	$message->setSubject("Nova mensagem no site do GPS");
	$message->setBody("Message from: <b>{$name}</b> ({$email}): <br><br>{$_POST['message']}", 'text/html');
	$message->setFrom(strip_tags($email));
	$message->setReplyTo(strip_tags($email));
	 
	// Send the email
	$mailer = Swift_Mailer::newInstance($transport);
	$mailer->send($message);
	
	echo 'success';
	
} else {
	echo 'invalid';
}

function validEmail($email=NULL)
{
	return preg_match( "/^[\d\w\/+!=#|$?%{^&}*`'~-][\d\w\/\.+!=#|$?%{^&}*`'~-]*@[A-Z0-9][A-Z0-9.-]{0,61}[A-Z0-9]\.[A-Z]{2,6}$/ix", $email );
}
