<?php
/**
 * Created by Julian Restrepo.
 * User: julian
 * Date: 4/30/13
 * Time: 12:55 PM
 *
 */
class ReportError
{
    public $allInfoError;
    public $userMsg;
    public $browser;
    public $ip;
    public $LineErr;
    public $CodeErr;
    public $fileErr;
    public $trace;
    public $Date;
    public $message;


    public function __construct(Exception $error){
        $this->setBrowser();
        $this->setip();
        $this->setLineErr($error->getLine());
        $this->setCodeErr($error->getCode());
        $this->setFileErr($error->getFile());
        $this->setTrace($error->getTraceAsString());
        $this->setDate(getdate());
        $this->setMessage($error->getMessage());
        $this->setAllInfoError();
        $this->addLog();
        //$this->setUsermsg();
        //$this->sendBugTMail();
        //this->sendDevelopMail();

    }

    public function  sendDevelopMail(){
	include_once("PHPMailer/class.phpmailer.php");
	$mail = new PHPMailer();
	$mail->IsSMTP(); // enable SMTP
	$mail->SMTPDebug = 1; // debugging: 1 = errors and messages, 2 = messages only
	$mail->SMTPAuth = true; // authentication enabled
	$mail->SMTPSecure = 'ssl'; // secure transfer enabled REQUIRED for GMail
	$mail->Host = "smtp.gmail.com";
	$mail->Port = 465; // or 587
	$mail->IsHTML(true);
	$mail->Username = "tecnicasavanzadaseia@gmail.com";
	$mail->Password = "tecnicas123";
	$mail->SetFrom('tecnicasavanzadaseia@gmail.com');
	$mail->Subject = "Error in code checker aplication";
	$mail->Body = $this->getAllInfoError();
	$mail->AddAddress('andreh2791@gmail.com');
	if(!$mail->Send())
    {
    echo "Mailer Error: " . $mail->ErrorInfo;
    }
    else
    {
    echo "Message has been sent";
    }
	

    }

    private function sendBugTMail(){

		include_once ('PHPMailer/class.phpmailer.php');
		include_once("PHPMailer/class.smtp.php");
		$mail = new phpmailer();
		$mail->PluginDir = "PHPMailer/";
		$mail->Mailer = "smtp";
		$mail->IsSMTP();
		$mail->Host = "smtp.gmail.com";
		$mail->Port = 587;
		$mail->SMTPSecure = "tls";
		$mail->SMTPAuth = true;
		$mail->Username = "tecnicasavanzadaseia@gmail.com"; 
		$mail->Password = "tecnicas123";
		$mail->SetFrom ( "tecnicasavanzadaseia@gmail.com");
		$mail->FromName = "Bug_reporter";
		//$mail->Timeout=20;
		$mail->AddAddress("cases@proyectotenicaseia.fogbugz.com");
		$mail->Subject = "bug";
		$mail->Body = $this->getAllInfoError();

		 if(!$mail->Send()) {
		  echo "Error: " . $mail->ErrorInfo;
		} else {
		  echo "Message has been sent";
		}
		
	
	
    }

    private function addLog(){
        $file = fopen("Logs/LogsFile.txt", "r+");
        $fcont = "***********************************************************".PHP_EOL.file_get_contents("Logs/LogsFile.txt");
        fwrite($file, $this->getAllInfoError().PHP_EOL.$fcont );
        fclose($file);
    }

    public function setUserMsg()
    {
        $this->userMsg = "This is embarrassing....";
    }

    public function getUserMsg()
    {
        return $this->userMsg;
    }

    public function setAllInfoError()
    {
        $this->allInfoError = $this->getFileErr().$this->getLineErr().$this->getCodeErr().$this->getTrace().$this->getMessage().
            $this->getBrowser().$this->getIp().$this->getDate();
    }

    public function getAllInfoError()
    {
        return $this->allInfoError;
    }

    public function setTrace($trace)
    {
        $this->trace = "Trace: ". $trace.PHP_EOL;
    }

    public function getTrace()
    {
        return $this->trace;
    }

    public function setMessage($message)
    {
        $this->message = "Message: ". $message.PHP_EOL;
    }

    public function getMessage()
    {
        return $this->message;
    }

    public function setLineErr($LineErr)
    {
        $this->LineErr = "The Line is: ". $LineErr.PHP_EOL;
    }

    public function getLineErr()
    {
        return $this->LineErr;
    }

    public function setBrowser()
    {
        $this->browser = "Browser: " . $_SERVER['HTTP_USER_AGENT'].PHP_EOL;;
    }

    public function getBrowser()
    {
        return $this->browser;
    }

    public function setIp()
    {
        $this->ip = "IP Address: " . $_SERVER['REMOTE_ADDR'].PHP_EOL;
    }

    public function getIp()
    {
        return $this->ip;
    }

    public function setDate($Date)
    {
        $this->Date = "Date: ". $Date['mday']. "-".$Date['month']."-".$Date['year'].
                      " Hour: ". $Date['hours'] .":".$Date['minutes'];
    }

    public function getDate()
    {
        return $this->Date;
    }

    public function setCodeErr($CodeErr)
    {
        $this->CodeErr = "The error code is: ".$CodeErr.PHP_EOL;
    }

    public function getCodeErr()
    {
        return $this->CodeErr;
    }

    public function setFileErr($fileErr)
    {
        $this->fileErr = "File: ".$fileErr.PHP_EOL;
    }

    public function getFileErr()
    {
        return $this->fileErr;
    }


}
