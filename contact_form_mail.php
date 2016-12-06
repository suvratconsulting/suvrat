<?php
/*include('PHPMailer/class.phpmailer.php');

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

/*$mail_sent = $email->Send();

if($mail_sent)
{
	echo "success";
}
else
{
	echo "failure";
}*/

function curPageURL() {
    $pageURL = 'http';
    if ($_SERVER["HTTPS"] == "on")
    {
        $pageURL .= "s";
    }
    $pageURL .= "://";
    if ($_SERVER["SERVER_PORT"] != "80") {
        $pageURL .= $_SERVER["SERVER_NAME"].":".$_SERVER["SERVER_PORT"].$_SERVER["REQUEST_URI"];
    } else {
        $pageURL .= $_SERVER["SERVER_NAME"].$_SERVER["REQUEST_URI"];
    }
    return $pageURL;
}

function login_and_generate_token($formdata)
{
    //Login using the Zoho credentials and get an Auth token
    $url="https://accounts.zoho.com/apiauthtoken/nb/create?SCOPE=ZohoCRM/crmapi&EMAIL_ID=vaibhavshah846@gmail.com&PASSWORD=\$Khiladi786\$&DISPLAY_NAME=[suvrat]";
    $auth_resp=CallRestAPI($url);

    //Check the result
    $auth_resp_result = substr($auth_resp,strpos($auth_resp,"RESULT")+7);

    if($auth_resp_result == "TRUE" or $auth_resp_result == "TRUE\n")
    {
        //Extract the Auth Token from the response
        $auth_token=substr($auth_resp,strpos($auth_resp,"AUTHTOKEN")+10,32);

        //Set it into the transient database for reuse
        $mem  = new Memcached();
        $mem->addServer('127.0.0.1',11211);
        $mem->add('zoho_suvrat_user_auth_token',$auth_token);
        return "Success";
    }
    else{
        ob_start();
        var_dump($auth_resp);
        $rst = ob_get_clean();
        $loc = curPageURL();
        $rst = $rst.PHP_EOL."Location: ".$loc;
        ob_start();
        print_r($formdata);
        $form_data = ob_get_clean();
        $rst = $rst.PHP_EOL."Form Data: ".$form_data;
        $rst=$rst.PHP_EOL."Zoho URL Called: ".$url;
        logZohoError($rst);
        return;
    }
}

function logZohoError($error)  {
    error_log('SUVRAT_Zoho_ERR::' . $error);

    try {
        //Mail details to Admin
        // the message
        $msg = 'SUVRAT_Zoho_ERR::' . $error;

        // use wordwrap() if lines are longer than 70 characters
        $msg = wordwrap($msg,70);

        $headers = "From: zoho_integrations@suvrat.com" . "\r\n" ;
        $recipients = array(
            'vaibhavshah846@gmail.com.au'
        );
        // send email
        mail($recipients,"Zoho API Integration error",$msg,$headers);
    } catch (Exception $e) {
        echo 'Caught exception while sending email: ',  $e->getMessage(), "\n";
    }
}

function handleErrResponse($resp,$xmlData,$formdata,$url)
{
    //Parse the response XML string
    $respXML=simplexml_load_string($resp);

    if(property_exists($respXML,error))
    {
        $error_code = $respXML->error->code;
        $error_msg = $respXML->error->message;

        if( $error_code[0] == "4834" && $error_msg[0] == "Invalid Ticket Id")
        {
            $mem  = new Memcached();
            $mem->addServer('127.0.0.1',11211);
            $mem->delete( 'zoho_suvrat_user_auth_token');

            //Token has been deleted,need to regenerate it
            $res=login_and_generate_token($formdata);
            if($res == "Success")
            {
                $auth_token = $mem->get( 'zoho_suvrat_user_auth_token');

                //Re-try insertion with new auth token
                $url="https://crm.zoho.com/crm/private/xml/Leads/insertRecords?newFormat=1&scope=crmapi&authtoken=";
                $url.=$auth_token;
                $url.="&xmlData=".$xmlData;
                $insert_resp = CallRestAPI($url);
            }
            else{
                return;
            }
        }
        else
        {
            //Some other error has occured
            ob_start();
            var_dump($respXML->error);
            $rst = ob_get_clean();
            $loc = curPageURL();
            $rst = $rst.PHP_EOL."Location: ".$loc;
            ob_start();
            print_r($formdata);
            $form_data = ob_get_clean();
            $rst = $rst.PHP_EOL."Form Data: ".$form_data;
            $rst = $rst.PHP_EOL."Zoho URL Called: ".$url;
            logZohoError('Error Code: '.$error_code[0].PHP_EOL.'Message: '.$error_msg[0].PHP_EOL.'VarDump: '.$rst);
            return;
        }
    }
}

function CallRestAPI($url , $method = 'GET', $data = false, $header = false)
{
    $curl = curl_init();

    switch ($method)
    {
        case "POST":
            curl_setopt($curl, CURLOPT_POST, 1);
            if ($data !== false)
                curl_setopt($curl, CURLOPT_POSTFIELDS, json_encode($data));
            break;

        default:
            if ($data !== false)
                $url = sprintf("%s?%s", $url, http_build_query($data));
            break;
    }

    curl_setopt($curl, CURLOPT_HTTPHEADER, $header);
    curl_setopt($curl, CURLOPT_URL, $url);
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
    //curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, 0); //temporary test mode

    $result = curl_exec($curl);

    /*$info = curl_getinfo($curl);
    if($info['http_code'] == 401)   {
        //401 Unauthorised Eventuosity Error
        logEventuosityError(date(DATE_RFC2822) . ' __CURL_ERROR__:: URL: ' . $url . ' :: Method: ' . $method . ' :: DATA: ' . print_r($data, true));
    }*/
    curl_close($curl);
    return $result;
}


$auth_token= "";

$mem  = new Memcached();

$mem->addServer('127.0.0.1',11211);

//delete_transient('zoho_suvrat_user_auth_token');
$auth_token = $mem->get( 'zoho_suvrat_user_auth_token');

if($auth_token == false)
{
    $res=login_and_generate_token($formdata);
    if($res == "Success")
    {
        $auth_token = $mem->get( 'zoho_suvrat_user_auth_token');
    }
    else{
        return;
    }
}

$first_name = "";
$last_name = "";
$name = $_POST['first_name'];
$email = $_POST['email_from'];
$company = $_POST['company'];
$phone = $_POST['telephone'];
$message = $_POST['message'];

if(sizeof(explode(" ", $name))>1)
{
    $first_name = explode(" ", $name)[0];
    $last_name = explode(" ", $name)[1];
}
else
{
    $last_name = $name;
    $first_name = "";
}


//Create the record to be inserted into Zoho
$xmlData = "<Leads><row no=\"1\">";
if($last_name)
{
    $xmlData.= "<FL val=\"Last Name\">".$last_name."</FL>";
}
if($first_name != "")
{
    $xmlData.= "<FL val=\"First Name\">".$first_name."</FL>";
}
if($email)
{
    $xmlData.= "<FL val=\"Email\">".$email."</FL>";
}
if($company)
{
    $xmlData.= "<FL val=\"Company\">".$company."</FL>";
}
if($phone)
{
    $xmlData.= "<FL val=\"Phone\">".$phone."</FL>";
}

$xmlData.= "<FL val=\"Description\">".$message."</FL>";

$xmlData .= "</row></Leads>";
$xmlData = urlencode($xmlData);

$url="https://crm.zoho.com/crm/private/xml/Leads/insertRecords?newFormat=1&scope=crmapi&authtoken=";
$url.=$auth_token."&xmlData=".$xmlData;
$insert_resp=CallRestAPI($url);
handleErrResponse($insert_resp,$xmlData,$POST,$url);
echo "success"
?>
