<?php

    Class CommentCheck{

        private $codeArray;
        private $errors;


        private $positions;
        private $numPositions;
        private $flag;
        private $numCodeLines;


        public function __construct($code){
            $this->setCodearray($code);
            $this->setPositions();
            $this->setCodeLines();

        }


        public function verify(){

            $this->checkBottom($this->codeArray, $this);
        }

        private function checkBottom(){

        }
        private function checkMiddle(){

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

        public function setNumCodeLines()
        {
            $this->numCodeLines = sizeof($this->codeArray);
        }

        public function getNumCodeLines()
        {
            return $this->numCodeLines;
        }


        public function setCodeArray($codeArray)
        {
            $this->codeArray = preg_split("/[(\r\n)]+/",$codeArray);
        }

        public function getCodeArray()
        {
            return $this->codeArray;
        }

        public function setErrors($errors)
        {
            $this->errors = $errors;
        }

        public function getErrors()
        {
            return $this->errors;
        }

        public function setFlag($flag, $cont)
        {
            $this->flag = $flag + $cont;
        }

        public function getFlag()
        {
            return $this->flag;
        }

        public function setPositions()
        {

            for ($i=0;$i<$this->codeLines;$i++){
                if (strpos($this->codeArray[$i], 'Class') !== false || strpos($this->codeArray, 'public') !== false
                    || strpos($this->codeArray[$i], 'function') !== false || strpos($this->codeArray[$i], 'static') !== false
                    || strpos($this->codeArray[$i], 'private') !== false){
                    $this->Postitions[] = $i;
                }
            }
        }

        public function getPositions()
        {
            return $this->positions;
        }

        public function setNumPositions($numPositions)
        {
            $this->numPositions = $numPositions;
        }

        public function getNumPositions()
        {
            return $this->numPositions;
        }

    }
?>