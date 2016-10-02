<?php
include('PHPMailer/class.phpmailer.php');

require_once('PHPMailer/class.smtp.php');

$email = new PHPMailer();
$email->IsSMTP();
$email->CharSet = 'UTF-8';
$email->Host       = "smtp.gmail.com"; // SMTP server
//$email->SMTPDebug  = 1;                     // enables SMTP debug information (for testing)
$email->SMTPAuth   = true;                  // enable SMTP authentication
$email->Port       = 25;                    // set the SMTP port for the GMAIL server
$email->Username   = "leads.suvrat@gmail.com"; // SMTP account username example
$email->Password   = "\$suvrat@consulting\$";        // SMTP account password example

//$email->From      = $_POST['email'];
$email->FromName  = $_POST['first_name'];
$email->Subject   = $_POST['company'];
$content = $_POST['message'] .PHP_EOL.'Phone Number: '. $_POST['telephone'].PHP_EOL.'Email: '.$_POST['email_from'];
$email->Body      = $content;
$email->AddAddress( 'leads.suvrat@gmail.com' );

/*$file_path = $_FILES['userfile']['tmp_name'];
$file_name = $_FILES['userfile']['name'];

$email->AddAttachment( $file_path, $file_name);*/

$mail_sent = $email->Send();

if($mail_sent)
{
	echo "success";
}
else
{
	echo "failure";
}
?>
