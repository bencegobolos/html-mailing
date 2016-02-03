<?php
// reCAPTCHA private key. Get your's at http://recaptcha.net.
$privatekey = '6LcyRxcTAAAAAFDa-ly6zjPdUxv0y-_X9cS3y9ri';
// Setting e-mail recipient.
$send_to = 'bencegobolos@gmail.com';
// To send HTML mail, the Content-type header must be set.
$headers  = 'MIME-Version: 1.0' . "\r\n";
$headers .= 'Content-type: text/html; charset=utf-8' . "\r\n";
// Additional headers.
$headers .= "From: <bencegobolos@gmail.com>" . "\r\n";
$headers .= "Return-Path: <bencegobolos@gmail.com>" . "\r\n";
$captcha = false;
$error_open = '<div class="alert-warning">';
$error_close = '</div>';

// E-mail validation.
function ABdevFW_email_validation ($email) {
  $regex = '/([a-z0-9_.-]+)' . '@' . '([a-z0-9.-]+){2,255}' . '.' . '([a-z]+){2,10}/i';
  if($email == '')
    return false;
  else
    $eregi = preg_replace($regex, '', $email);
  return empty($eregi) ? true : false;
}

// Error messages.
if($_POST['contact-name']=='')
  die ($error_open . "Name is required!" . $error_close);
if(!ABdevFW_email_validation($_POST['contact-email']))
  die ($error_open . "Valid email is required!" . $error_close);
if($_POST['contact-subject']=='')
  die ($error_open . "Subject is required!" . $error_close);
if($_POST['contact-message']=='')
  die ($error_open . "Message is required!" . $error_close);
if(isset($_POST['g-recaptcha-response']))
  $captcha=$_POST['g-recaptcha-response'];
if(!$captcha) {
  die ($error_open . "Check your reCAPTCHA!" . $error_close);
  exit;
}

$response=file_get_contents("https://www.google.com/recaptcha/api/siteverify?secret=" . $privatekey . "&response=" . $captcha . "&remoteip=" . $_SERVER['REMOTE_ADDR']);
if($response==false)
  echo '<h2>You are spammer ! Get the @$%K out</h2>';
else {
  // Sending e-mail.
  $subject = htmlentities($_POST['contact-subject']);
  $message = 'Name: ' . htmlentities($_POST['contact-name']) . "\nEmail: " . $_POST['contact-email'] . "\n" . "Sent you a message: \n" . htmlentities($_POST['contact-message']);
  mail($send_to, $subject, $message, $headers);
  echo 'OK';
}