<?php

    Class CommentCheck{

        private $codeArray;
        private $errors;
        private $positions;
        private $numTimes;
        private $flag;
        private $numCodeLines;
        private $position;

        public function __construct($code){
            $this->setCodearray($code);
            $this->setNumCodeLines();
            $this->setPositions();
        }

        public function verify(){
            $this->setNumTimes(sizeof($this->getPositions()));
            for ( $i = 0; $i < $this->getNumTimes(); $i++){
                $this->setPosition( $this->positions[$i] - 1);
                $this->checkBottom();
            }

        }

        private function checkBottom(){
            $this->setFlag(0);
            if ( preg_match('/^([\s]*)(\*)+.*/', $this->codeArray[$this->getPosition()])){
                $this->setPosition( $this->getPosition() - 1);
                $this->checkMiddle();
            }
            else {
                $this->setErrors('La linea numero ' . $this->getPosition() . ', esta mal comentada => '
                . $this->codeArray[$this->getPosition()]);
            }
        }
        private function checkMiddle(){

            if (( preg_match('/^([\s]*)(\*)+(.)*/', $this->codeArray[$this->getPosition()]))
                && ( strpos( $this->codeArray[$this->getPosition()], "*/") === false)){
                $this->setFlag( $this->getFlag() + 1);
                $this->setPosition( $this->getPosition() - 1);
                $this->checkMiddle();
            }
            else if( preg_match('/^([\s]*)\/([\*]{2})$/', $this->codeArray[$this->getPosition()]) && ( $this->getFlag() > 0)){
                $this->checkTop();

            }
            else {

                $this->setErrors('La linea numero ' . $this->getPosition() . ', esta mal comentada => '
                . $this->codeArray[$this->getPosition()]);
            }
        }

        private function setPositions()
        {

            for ( $i = 0; $i < $this->getNumCodeLines(); $i++){
                if ( strpos( $this->codeArray[$i], 'Class') !== false || strpos( $this->codeArray[$i], 'public') !== false
                    || strpos( $this->codeArray[$i], 'function') !== false || strpos( $this->codeArray[$i], 'static') !== false
                    || strpos( $this->codeArray[$i], 'private') !== false){
                    $this->positions[] = $i;
                }
            }
        }

        private function checkTop(){

        }
        private function checkTags(){

        }
        private function checkBlankLine(){

        }
        private function checkAlign(){

        }
        private function checkProportion(){

        }

        public function setPosition($position)
        {
            $this->position = $position;
        }

        public function getPosition()
        {
            return $this->position;
        }

        public function setNumCodeLines()
        {
            $this->numCodeLines = sizeof( $this->getCodeArray());
        }

        public function getNumCodeLines()
        {
            return $this->numCodeLines;
        }

        public function setCodeArray($codeArray)
        {
            $this->codeArray = preg_split("/[(\r\n)]+/", $codeArray);
        }
        public function getCodeArray()
        {
            return $this->codeArray;
        }

        public function setErrors($errors)
        {
            $this->errors[] = $errors;
        }

        public function getErrors()
        {
            return $this->errors;
        }

        public function setFlag($flag)
        {
            $this->flag = $flag;
        }

        public function getFlag()
        {
            return $this->flag;
        }

        public function getPositions()
        {
            return $this->positions;
        }

        public function setNumTimes($numTimes)
        {
            $this->numTimes = $numTimes;
        }

        public function getNumTimes()
        {
            return $this->numTimes;
        }

    }
?>