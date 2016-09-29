<?php
include('PHPMailer/class.phpmailer.php');

require_once('PHPMailer/class.smtp.php');

$content = 'PFA a candidate resume';
$email = new PHPMailer();
$email->IsSMTP();
$email->CharSet = 'UTF-8';
$email->Host       = "smtp.gmail.com"; // SMTP server
//$email->SMTPDebug  = 1;                     // enables SMTP debug information (for testing)
$email->SMTPAuth   = true;                  // enable SMTP authentication
$email->Port       = 25;                    // set the SMTP port for the GMAIL server
$email->Username   = "careers.suvrat@gmail.com"; // SMTP account username example
$email->Password   = "\$suvrat@consulting\$";        // SMTP account password example

$email->From      = 'careers.suvrat@gmail.com';
$email->FromName  = 'Careers At Suvrat Consulting';
$email->Subject   = 'New Candidate Resume';
$email->Body      = $content;
$email->AddAddress( 'dpdeveshpal9@gmail.com' );

$file_path = $_FILES['userfile']['tmp_name'];
$file_name = $_FILES['userfile']['name'];

$email->AddAttachment( $file_path, $file_name);

$mail_sent = $email->Send();

if($mail_sent)
{
	return "Success";
}
else
{
	return "Failure";
}
?>