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
            $this->setPositions();
            $this->setCodeLines();
            $this->setCont(0);
        }

        public function setPosition($position)
        {
            $this->position = $position;
        }

        public function getPosition()
        {
            return $this->position;
        }

        public function verify(){
            $this->setTimes(sizeof($this->getPositions()));

            for ($i=0; $this->getTimes(); $i++){
                 $this->setPosition($this->getPositions()[$i]-1);
                 $this->checkBottom();
            }

        }

        private function checkBottom(){
            if (preg_match('/^([\s]*)(\*\/)$/', $this->getCodeArray()[$this->getPosition()])){
                $this->setPosition($this->getPosition()-1);
                $this->checkMiddle();
            }
            else {
                $this->setErrors('La l&iacutenea n&uacutemero  ' . $this->getPosition()+1 . ', esta mal comentada =>
                '. $this->getArrayCode()[$this->getPosition()+1]);
                // echo "<p>No entra A -" . $str[$i] . "-</p>" . $i;
                //echo '<div class="error">La l&iacutenea n&uacutemero  ' .($i+1). ', esta mal comentada =>  '.$str[$i+1].'</div>' ;
            }
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
            $this->numCodeLines = sizeof($this->getCodeArray());
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
            $this->errors[] = $errors;
        }

        public function getErrors()
        {
            return $this->errors;
        }

        public function setFlag()
        {
            $this->flag = $this->getFlag() + 1;
        }

        public function getFlag()
        {
            return $this->flag;
        }

        public function setPositions()
        {

            for ($i=0;$i<$this->getNumCodeLines();$i++){
                if (strpos($this->getCodeArray()[$i], 'Class') !== false || strpos($this->getCodeArray()[$i], 'public') !== false
                    || strpos($this->getCodeArray()[$i], 'function') !== false || strpos($this->getCodeArray()[$i], 'static') !== false
                    || strpos($this->getCodeArray()[$i], 'private') !== false){
                    $this->positions[] = $i;
                }
            }
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