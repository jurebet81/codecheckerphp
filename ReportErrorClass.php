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

    private function  sendDevelopMail(){

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
