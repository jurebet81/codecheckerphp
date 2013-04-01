<?php
/**
 * Created by Julian Restrepo
 * User: Julian
 * Date: 3/14/13
 * Time: 8:40 PM
 *
 */
        /**
         * CommentChek
         *
         * Review code errors and return a vector with them
         * 
         */

    Class CommentCheck{

        private $codeArray;
        private $errors;
        private $positions;
        private $numTimes;
        private $flag;
        private $numCodeLines;
        private $position;

        /**
         * Constructor
         *
         * Gets the code as a string and calls the method to put it into an array
         * Calls the method to find how many classes and methods there are in the php file
         *
         * @param (string)($code)
         */

        public function __construct($code){
            $this->setCodearray($code);
            $this->setNumCodeLines(sizeof( $this->getCodeArray()));
            $this->setPositions();
            $this->setNumTimes(sizeof($this->getPositions()));
        }

        /**
         * Verify
         *
         * Starts to verify each comment in the code depending on how many classes and methods were found
         *
         */

        public function verify(){
            for ( $i = 0; $i < $this->getNumTimes(); $i++){
                $this->setPosition( $this->positions[$i]);
                $this->align();
                $this->setLastLine(false);
                $this->setPosition( $this->positions[$i] - 1);
                $this->checkBlankLine();
            }

        }

        /**
         * checkBottom
         *
         * Checks the bottom of each comment
         *
         */

        private function checkBottom(){
            $this->setFlag(0);
            if ( preg_match('/^([\s]*)(\*)(\/)$/', $this->codeArray[$this->getPosition()])){
                $this->setPosition( $this->getPosition() - 1);
                $this->align();
                $this->checkMiddle();
            }
            else {
                $this->setErrors('Line: ' . $this->getPosition() . ', is not commented properly => '
                . $this->codeArray[$this->getPosition()]);
            }
        }

        /**
         * checkMiddle
         *
         * Checks the middle of the each comment and its beginning
         *
         */

        private function checkMiddle(){
            if (( preg_match('/^([\s]*)(\*)+(.)*/', $this->codeArray[$this->getPosition()]))
                && ( strpos( $this->codeArray[$this->getPosition()], "*/") === false)){
                $this->setFlag( $this->getFlag() + 1);
                $this->setPosition( $this->getPosition() - 1);
                $this->align();
                $this->checkMiddle();
            }
            else if( preg_match('/^([\s]*)\/([\*]{2})$/', $this->codeArray[$this->getPosition()]) && ( $this->getFlag() > 0)){
                $this->setLastLine(true);
                $this->align();
                $this->checkTop();
            }
            else {

                $this->setErrors('Line: ' . $this->getPosition() . ', is not commented properly => '
                . $this->codeArray[$this->getPosition()]);
            }
        }

        /**
         * setPositions
         *
         * Sets positions into an array where the methods and classes were found
         *
         */

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

        /**
         * checkBlankLine
         *
         * Verify each class and funtion in the code has a blank line before 
         *
         */

        private function checkBlankLine(){

            if ( !empty($this -> codeArray[$this->getPosition()])){
                $this->setErrors('Line: ' . ($this->getPosition()+1). ', there is not a black line between the comment and the class');
            }
            else{ 
                $this->setPosition( $this->getPosition()-1);
                $this->align();
                $this->checkBottom();
            }
        }
    
        /**
         * align
         *
         * Calculate spaces and tabs at the beginning of each class,funtion or comment line 
         *
         */

        private function align(){
            $this->setLineArray (  $this->codeArray[$this->getPosition()]);
            $this->setNumCharactersLine (sizeof( $this->getLineArray()));
            for ($i = 0; $i < $this->getNumCharactersLine(); $i++) {
                $this->setAscii ( ord($this->lineArray[$i]));
              if ($this->getAscii() == 32){
                    $this->setCountSpaces ($this ->getCountSpaces()+ 1);
                }elseif($this->getAscii() == 9){
                    $this->setCountSpaces ($this ->getCountSpaces()+ 4);
                    }else{
                         $i=$this->getNumCharactersLine();
                    }   
                $this->setAscii (0);
            }
            $this->setAlignArray ( $this->getCountSpaces());
            $this->setCountSpaces (0);
            $this->checkAlign();
        }
        
        /**
         * checkAlign
         *
         * Compare spaces of the class or funtion with each line of the comment
         * The beginning of the comment must be the same position as the class or funtion
         *
         */

        private function checkAlign(){
            //echo $lastLine;
            $i=sizeof($this -> getAlignArray());
            if ( $i == 1){
                $this->setAligner ($this->alignArray[$i-1] + 1);
                echo $this->getAligner();
            }elseif($this->alignArray[$i-1] != $this->getAligner()){
                if (!(($this->getLastLine() == true) &&  ( ($this->alignArray[$i-1]+1) == $this->getAligner() ))){
                    $this->setErrors('Line: ' . ($this->getPosition()+1). ', is not aligned with the class');
                }
                
            }
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

        public function setNumCodeLines($numCodeLines)
        {
            $this->numCodeLines = $numCodeLines;
        }

        public function getNumCodeLines()
        {
            return $this->numCodeLines;
        }

        /**
         * CodeArray
         *
         * Splits the code and put all of these lines into an array, each line is new position in that array
         *
         * @param $codeArray
         */
        public function setCodeArray($codeArray)
        {
            $this->codeArray = preg_split("/(\n|\r\n)/", $codeArray);
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
        
        public function setLineArray($lineArray)
        {
            $this->lineArray = str_split($lineArray);
        }

        public function getLineArray()
        {
            return $this->lineArray;
        }

        public function setAlignArray($alignArray)
        {
            $this->alignArray[] = $alignArray;
        }

        public function getAlignArray()
        {
            return $this->alignArray;
        }

		public function setNumCharactersLine($numCharactersLine)
        {
            $this->numCharactersLine= $numCharactersLine;
        }

        public function getNumCharactersLine()
        {
            return $this->numCharactersLine;
        }

        public function setAscii($ascii)
        {
            $this->ascii = $ascii;
        }

        public function getAscii()
        {
            return $this->ascii;
        }   
        
        public function setCountSpaces($countSpaces)
        {
            $this->countSpaces = $countSpaces;
        }

        public function getCountSpaces()
        {
            return $this->countSpaces;
        }
        
        public function setAligner($aligner)
        {
            $this->aligner = $aligner;
        }

        public function getAligner()
        {
            return $this->aligner;
        }
        public function setLastLine($lastLine)
        {
            $this->lastLine = $lastLine;
        }

        public function getLastLine()
        {
            return $this->lastLine;
        }
    }
?>