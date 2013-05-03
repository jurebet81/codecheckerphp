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

    public function __construct(Exception $error){

        //$this->setUsermsg();
        $this->setAllInfoError($error);
        $this->addLog();
        //$this->sendBugTMail();
        //this->sendDevelopMail();

    }

    public function  sendDevelopMail(){
	include_once("class.phpmailer.php");
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

		include_once ('class.phpmailer.php');
		include_once("class.smtp.php");
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
        $file = fopen("LogFile.txt", "r+");
        $fcont = "******************************************".PHP_EOL.file_get_contents("LogFile.txt");
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

    public function setAllInfoError(Exception $e) //MARCELA ORGANIZAS ESTO ACA PARA QUE TE QUEDE BIEN BONITO ES MUY FACIL :)
    {
        $a = $e->getFile(); //obtiene el nombre del archivo
        $b = $e->getLine(); //obtiene linea del archivo
        $this->allInfoError = $a;
    }

    public function getAllInfoError()
    {
        return $this->allInfoError;
    }

}
