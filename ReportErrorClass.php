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

    public function __construct($error){

        $this->setUsermsg();
        $this->setAllInfoError();
        $this->sendBugTMail();
        $this->sendDevelopMail();
    }

    private function  sendDevelopMail(){

    }

    private function sendBugTMail(){

    }

    private function addLog(){

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

    }

    public function getAllInfoError()
    {
        return $this->allInfoError;
    }

}
