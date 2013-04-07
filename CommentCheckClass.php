<?php

/**
 * Created by Julian Restrepo
 * User: Julian
 * Date: 3/14/13
 * Time: 8:40 PM
 *
 */

/**
 * CommentCheck
 *
 * Review code errors and return a vector with them
 * 
 */
Class CommentCheck {

    public $codeArray;
    private $errors;
    private $positions;
    private $numTimes;
    private $flag;
    private $numCodeLines;
    private $position;
    private $tags;
    private $bottom;

    private $spaces;
    private $lineArray;
    private $numCharactersLine;
    private $ascii;

    /**
     * constructor
     *
     * Gets the code as a string and calls the method to put it into an array
     * Calls the method to find how many classes and methods there are in the php file
    *
     * @param (string)($code)
     */
    public function __construct($code, $tags) {
        $this->setCodearray($code);
        $this->setNumCodeLines(sizeof($this->getCodeArray()));
        $this->setPositions();
        $this->setNumTimes(sizeof($this->getPositions()));
        $this->setTags($tags);
    }

    /**
     * Verify
     *
     * Starts to verify each comment in the code depending on how many classes and methods were found
     *
     */
    public function verify() {
        for ($i = 0; $i < $this->getNumTimes(); $i++) {
            $this->setSpaces(0);
            $this->setPosition(($this->positions[$i]));
            $this->setSpaces($this->codeArray[$this->positions[$i]]);
			$this->setPosition(($this->positions[$i]) - 1);
		    $this->setBottom(($this->getPosition())+1);
            $this->checkBottom();
        }
    }

/**
    private function hasComment(){
        $n = $this->getPosition();
        if ($n < 2){
            $this->setErrors('The Class: ' . $this->codeArray[$this->getPosition()+1] . ', does not have its comment');
        }else {
            for ($i=$n;$i>1;$i--){
                if ($this->codeArray[$i] ){

                }
            }

        }
    }

    /**
     * checkBottom
     *
     * Checks the bottom of each comment
     *
     */

    private function checkBottom() {
        $this->setFlag(0);
        if ($this->getPosition() > 2){
            while ((empty($this->codeArray[($this->getPosition())])) ||
            (preg_match('/^([\s]+)$/', $this->codeArray[($this->getPosition())])) ){
            $this->setPosition($this->getPosition() - 1);
            $this->setErrors('Line: ' . ($this->getPosition() + 2 )  . ', can not be empty');
            }

            if ( preg_match('/(\s}|[}])+/', $this->codeArray[($this->getPosition())])==false ){
                if ( preg_match('/^([\s]*)(\*)(\/)([\s]*)$/', $this->codeArray[($this->getPosition())])) {
                    $this->checkAlign($this->codeArray[($this->getPosition())], $this->getSpaces());
                    $this->setPosition($this->getPosition() - 1);
                    $this->checkMiddle();
                } else {
                    $this->setErrors('Line: ' . ($this->getPosition() + 1) . ', is not commented properly => '
                            . $this->codeArray[$this->getPosition()]);
                    $this->setPosition($this->getPosition() - 1);
                    //$this->checkMiddle();
                }
            }else{
                $this->setErrors('The method: ' . $this->codeArray[$this->getPosition()+2] . ', does not have its comment');
            }
        }else{
            $this->setErrors('The Class: ' . $this->codeArray[$this->getPosition()+1] . ', does not have its comment');
        }
    }

    /**
     * checkMiddle
     *
     * Checks the middle of the each comment
     *
     */
    private function checkMiddle() {
        if (( preg_match('/^([\s]*)(\*)+(.)*/', $this->codeArray[$this->getPosition()]))
                && ( strpos($this->codeArray[$this->getPosition()], "*/") === false)) {
            $this->setFlag($this->getFlag() + 1);
            $this->checkAlign($this->codeArray[($this->getPosition())], $this->getSpaces());

            $this->setPosition($this->getPosition() - 1);
            $this->checkMiddle();
        } else if (preg_match('/^([\s]*)\/(\*)+$/', $this->codeArray[$this->getPosition()]) && ( $this->getFlag() > 0)) {
            $this->checkTop();
        } else {
            $this->setErrors('Line: ' . ($this->getPosition() + 1) . ', is not commented properly => '
                    . $this->codeArray[$this->getPosition()]);
            $this->setPosition($this->getPosition() - 1);
            $this->checkMiddle();
        }
    }

    /**
     * checkTop
     *
     * Checks the top of the each comment
     *
     */
    private function checkTop() {
        if (!(preg_match('/^([\s]*)\/([\*]{2})([\s]*)$/', $this->codeArray[$this->getPosition()]))) {
            $this->setErrors('Line: ' . ($this->getPosition() + 1) . ', is not commented properly => '
                    . $this->codeArray[$this->getPosition()]);
        }
        $this->checkAlign($this->codeArray[($this->getPosition())], $this->getSpaces());
        $this->setPosition($this->getPosition() - 1);
        $this->checkBlankLine();
        $this->checkTags();
    }

    /*
     * setPositions
     *
     * Sets positions into an array where the methods and classes were found
     *
     */
    private function setPositions() {
        for ($i = 0; $i < $this->getNumCodeLines(); $i++) {
            if (strpos($this->codeArray[$i], 'Class') !== false || strpos($this->codeArray[$i], 'public') !== false
                    || strpos($this->codeArray[$i], 'function') !== false || strpos($this->codeArray[$i], 'static') !== false
                    || strpos($this->codeArray[$i], 'private') !== false) {
                $this->positions[] = $i;
            }
        }
    }

    /**
     * Title: checkTags
     * Method that checks that the tags the user whats to check are correctly
     * commented on the comment.
     */
    private function checkTags() {
        $contAuthor = 0;
        $contReturn = 0;
        $contParam = 0;
        $tagArray = $this->tags;
        $position = $this->getPosition();
        $length = sizeof($this->getTags());
        for ($j = 0; $j < $length; $j++) {

            if ($tagArray[$j] == 'title') {
                /*
                 * checks that the first line after /** of all comments are the title
                 *
                 */
                if (!(preg_match('/^([\s]*)(\*)[\s]((title)|(Title))(:)?.+/', $this->codeArray[$position + 1]) )) {
                    $this->setErrors('Line number ' . ($this->getPosition() + 2) . ', is wrong  => '
                            . $this->codeArray[$position + 1] . ' The comment does not have title tag');
                }
            }

            if ($tagArray[$j] == 'author') {

                for ($m = $this->getPosition(); $m < $this->bottom; $m++) {
                    if ((preg_match('/([\s]*)[\s]((author)|(Author)|(@author))(:)?.+/', $this->codeArray[$m + 1]))) {
                        $contAuthor = 1;
                    }
                }
                if ($contAuthor == 0) {
                    $this->setErrors('The comment does not have author tag.  Comment => ' . $this->codeArray[($this->bottom)]);
                }
            }
            if (!(preg_match('/^([\s]*)(Class).+/', $this->codeArray[($this->bottom)]))) {
                if ($tagArray[$j] == 'return') {
                    for ($m = $this->getPosition(); $m < $this->bottom; $m++) {
                        if ((preg_match('/([\s]*)[\s]((return)|(Return)|(@return))(:)?.+/', $this->codeArray[$m]))) {
                            $contReturn = 1;
                        }
                    }
                    if ($contReturn == 0) {
                        $this->setErrors('The comment does not have return tag.  Comment => ' . $this->codeArray[($this->bottom)]);
                    }
                }
                if ($tagArray[$j] == 'param') {
                    for ($m = $this->getPosition(); $m < $this->bottom; $m++) {
                        if ((preg_match('/([\s]*)[\s]((param)|(Param)|(@param))(:)?.+/', $this->codeArray[$m]))) {
                            $contParam = 1;
                        }
                    }
                    if ($contParam == 0) {
                        $this->setErrors('The comment does not have param tag.  Comment => ' . $this->codeArray[($this->bottom)]);
                    }
                }
            }
        }
    }

    /**
     * checkBlankLine
     *
     * Verify each comment in the code has a blank line before
     *
     */
    private function checkBlankLine() {
        if ($this->getPosition()>1){
            $x = $this->getPosition() + 1;
            if (!empty($this->codeArray[$this->getPosition()])) {
                $this->setErrors('Line: ' . $x . ', there is not a black line above the comment');
            }
        }
    }

    private function checkProportion(){

    }

    /**
     * checkAlign
     *
     * Compare spaces of the class or function with each line of the comment
     * The beginning of the comment must be the same position as the class or funtion
     *
    */
    private function checkAlign($codeLine,$spaces) {
        $spacesComment = 0;
        $this->setLineArray($codeLine);
        $this->setNumCharactersLine(sizeof($this->getLineArray()));
        for ($x = 0; $x < $this->getNumCharactersLine(); $x++) {
            $this->setAscii(ord($this->lineArray[$x]));
            if ($this->getAscii() == 32) {
                $spacesComment = $spacesComment + 1;
            } elseif ($this->getAscii() == 9) {
                $spacesComment = $spacesComment + 4;
            } else {
                $x = $this->getNumCharactersLine();
            }
        }

        if ($spacesComment <> $spaces){
            $this->setErrors('Line: ' . ($this->getPosition() + 1) . ', is not aligned with the class');
        }

    }

    public function setPosition($position) {
        $this->position = $position;
    }

    public function getPosition() {
        return $this->position;
    }

    public function setNumCodeLines($numCodeLines) {
        $this->numCodeLines = $numCodeLines;
    }

    public function getNumCodeLines() {
        return $this->numCodeLines;
    }

    /**
     * CodeArray
     *
     * Splits the code and put all of these lines into an array, each line is new position in that array
     *
     * @param $codeArray
     */
    public function setCodeArray($codeArray) {
        $this->codeArray = preg_split("/(\n|\r\n)/", $codeArray);
    }

    public function getCodeArray() {
        return $this->codeArray;
    }

    public function setErrors($errors) {
        $this->errors[] = $errors;
    }

    public function getErrors() {
        return $this->errors;
    }

    public function setTags($tags) {

        $this->tags = $tags;
    }

    public function getTags() {
        return $this->tags;
    }

    public function setFlag($flag) {
        $this->flag = $flag;
    }

    public function getFlag() {
        return $this->flag;
    }

    public function getPositions() {
        return $this->positions;
    }

    public function getBottom() {
        return $this->bottom;
    }

    public function setBottom($bottom) {
        $this->bottom = $bottom;
    }

    public function setNumTimes($numTimes) {
        $this->numTimes = $numTimes;
    }

    public function getNumTimes() {
        return $this->numTimes;
    }

    public function setLineArray($lineArray) {
        $this->lineArray = str_split($lineArray);
    }

    public function getLineArray() {
        return $this->lineArray;
    }

    public function setNumCharactersLine($numCharactersLine) {
        $this->numCharactersLine = $numCharactersLine;
    }

    public function getNumCharactersLine() {
        return $this->numCharactersLine;
    }

    public function setAscii($ascii) {
        $this->ascii = $ascii;
    }

    public function getAscii() {
        return $this->ascii;
    }

    /**
     * setSpaces
     *
     * Calculate spaces and tabs at the beginning of each class,function or comment line
     *
     *
     */
    public function setSpaces($codeLine)
    {
        $this->setLineArray($codeLine);
        $this->setNumCharactersLine(sizeof($this->getLineArray()));
        for ($x = 0; $x < $this->getNumCharactersLine(); $x++) {
            $this->setAscii(ord($this->lineArray[$x]));
            if ($this->getAscii() == 32) {
                $this->spaces = $this->getSpaces() + 1;
            } elseif ($this->getAscii() == 9) {
                $this->spaces = $this->getSpaces() + 4;
            } else {
                $x = $this->getNumCharactersLine();
            }
        }

    }

    public function getSpaces()
    {
        return $this->spaces;
    }


}

?>