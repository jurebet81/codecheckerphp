<?php

    Class CommentCheck{

        private $codeArray;
        private $errors;
        private $positions;
        private $flag;


        public function __construct($code){
            $this->setCodearray($code);

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





        public function setCodeArray($codeArray)
        {
            $this->codeArray = $codeArray;
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

        public function setFlag($flag)
        {
            $this->flag = $flag;
        }

        public function getFlag()
        {
            return $this->flag;
        }

        public function setPositions($positions)
        {
            $this->positions = $positions;
        }

        public function getPositions()
        {
            return $this->positions;
        }



    }
?>