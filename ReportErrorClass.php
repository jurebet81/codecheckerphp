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
    public $lineErr;


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
	$mail->Body = $this->getAllInfoError;
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

    public function setAllInfoError(Exception $e)
    {
        $a = $e->getFile(); //obtiene el nombre del archivo
        $b = $e->getLine(); //obtiene linea del archivo
        $c = $e->getCode();
        $d = $e->getMessage();
        $f = $e->getPrevious();
        $g = $e->getTrace();
        $h = $e->getTraceAsString();
        $i1 =  $_SERVER['HTTP_USER_AGENT'];
        //$i2 = get_browser(null, true);
        $i2 = "";
        $j = getdate();
        $k = $j['hours'].":".$j['minutes'];
        $j = $j['year']."-".$j['month']."-".$j['mday'];

        $l = $_SERVER['REMOTE_ADDR'];

        $this->allInfoError = "File:".$a.PHP_EOL."Line:".PHP_EOL.$b."Code:".PHP_EOL.$c."mensaje:".PHP_EOL.$d."PREVIOUS:".PHP_EOL.$f.
            "rastro:".PHP_EOL.$g."rastrocomocadena".PHP_EOL.$h."SERVIDOR".PHP_EOL.$i1."MM".$i2.PHP_EOL."FECHA:".$j.PHP_EOL."HORA:".$k.PHP_EOL."ip:".$l;
    }

    public function getAllInfoError()
    {
        return $this->allInfoError;
    }

}
