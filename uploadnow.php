
<?php

/*$upload_dir = 'myuploads';

if (!empty($_FILES)) {

 $tempFile = $_FILES['file']['tmp_name'];

 echo $tempFile;
 // using DIRECTORY_SEPARATOR constant is a good practice, it makes your code portable.
 $targetPath = dirname( __FILE__ ) . DIRECTORY_SEPARATOR . $upload_dir . DIRECTORY_SEPARATOR;
 // Adding timestamp with image's name so that files with same name can be uploaded easily.
 $mainFile = $targetPath.time().'-'. $_FILES['file']['name'];

 move_uploaded_file($tempFile,$mainFile);

}*/
include('PHPMailer/class.phpmailer.php');

require_once('PHPMailer/class.smtp.php');

$content = 'PFA a candidate resume';
$email = new PHPMailer();
$email->IsSMTP();
$email->CharSet = 'UTF-8';
$email->Host       = "smtp.gmail.com"; // SMTP server
$email->SMTPDebug  = 1;                     // enables SMTP debug information (for testing)
$email->SMTPAuth   = true;                  // enable SMTP authentication
$email->Port       = 25;                    // set the SMTP port for the GMAIL server
$email->Username   = "careers.suvrat@gmail.com"; // SMTP account username example
$email->Password   = "\$consulting@suvrat\$";        // SMTP account password example

$email->From      = 'careers.suvrat@gmail.com';
$email->FromName  = 'Careers At Suvrat Consulting';
$email->Subject   = 'New Candidate Resume';
$email->Body      = $content;
$email->AddAddress( 'careers.suvrat@gmail.com' );

if (!empty($_FILES)) {
	$file_path = $_FILES['file']['tmp_name'];
	$file_name = $_FILES['file']['name'];
}
/*else{
	return "Please attach a your resume before submitting";
}*/

$email->AddAttachment( $file_path, $file_name);

$mail_sent = $email->Send();

if($mail_sent)
{
	$response_array['status'] = 'success';    
}
else
{
	$response_array['status'] = 'failure';    
}
header('Content-type: application/json');
echo json_encode($response_array);
?>
