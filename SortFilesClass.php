<?php

/**
 * Created by JetBrains PhpStorm.
 * User: User
 * Date: 3/18/13
 * Time: 8:27 PM
 *
*/
class SortFiles
{
    private $fileArray;
    private $totFiles;
    private $dirPath;
    private $totPhpFiles;
    public  $filePhpArray;
    private $tags;
    private $messages;
    private $arguments;
    private $totArguments;

    /**
     * Constructor
     *
     * Gets the arguments that were passed through the command prompt putting them into an array
     *
     * @param string $args
     */

    public function __construct($args){
        $this->setArguments($args);
        $this->setDirPath("");
        $this->setTotFiles(0);
        $this->setFileArray("");
        $this->setTotPhpFiles(0);
        $this->setTotArguments(sizeof($args));
    }

    /**
     * startSorting
     *
     * Depending on the first argument passed, these method calls the method which will sort the php files
     *
     */

    public function startSorting(){
        if ( $this->getTotArguments() > 3){
            $this->sortTags($this->arguments[1]);
            if ( $this->arguments[2] == "f"){
                $this->orderByFiles( $this->getArguments());
            } else if ( $this->arguments[2] == "d") {
                $this->orderByDirectory( $this->getArguments());
            }else {
                $this->setMessages("Parameters are not valid");
            }
        }else{
            $this->setMessages("There are not enough arguments");
        }
    }

    /**
     * loadAllFiles
     *
     * Puts the files of a specific directory into a file array.
     *
     * @param string $directory
     *
     */

    private function loadAllFiles($directory){
        $this->setFileArray( scandir($directory));
        $this->setTotFiles( sizeof( $this->getFileArray()));
    }

    /**
     * loadPhpFiles
     *
     * Catches the php files and puts them into a new array that is called filephparray
     *
     * @param $files
     */

    private function loadPhpFiles($files){
        for ( $i = 0; $i < $this->getTotFiles(); $i++){
            if ( preg_match('/^(.)+\.(php)$/', $files[$i])){
                $this->setFilePhpArray( $files[$i]);
            }
        }
        $this->setTotPhpFiles( sizeof( $this->getFilePhpArray()));
    }

    /**
     * orderByDirectory
     *
     * verifies if the directory passed exists
     *
     * @param string $directory
     */

    private function orderByDirectory($directory){
        if ( is_dir( $directory[3])){
            $this->setDirPath( $directory[3] . "/");
            $this->loadAllFiles( $this->getDirPath());
            $this->loadPhpFiles( $this->getFileArray());
        }else{
            $this->setMessages( $directory[3] . " is not a directory") ;
        }
    }

    /**
     * orderByFiles
     *
     * verifies if the files passed exist
     *
     * @param $files
     *
     */

    private function orderByFiles($files){
        $this->setDirPath("");
        $filesAux = "";
        for ( $i = 3; $i < $this->getTotArguments(); $i++){
            if ( is_file( $files[$i])) {
                $filesAux[] = $files[$i];
            }else{
                $this->setMessages( $files[$i] . " is not a file");
            }
        }
        if ( sizeof( $filesAux) > 0){
            $this->setTotFiles( sizeof( $filesAux));
            $this->setFileArray( $filesAux);
            $this->loadPhpFiles( $filesAux);
        }else{
            $this->setMessages("There was an error getting the files");
        }
    }

    /**
     * sortTags
     *
     * puts the total of the tags chosen into an array
     *
     * @param $tags
     *
     */

    private function sortTags($tags){
        $sizeArg = strlen($tags);
        for ( $i=0;$i<$sizeArg;$i++){
            if( $tags[$i]=="a"){
                $this->setTags("author");
                echo "author";
            }else if( $tags[$i]=="r"){
                $this->setTags("return");
                echo "return";
            }else if( $tags[$i]=="t"){
                $this->setTags("title");
                echo "title";
            }else if( $tags[$i]=="p"){
                $this->setTags("param");
                echo "param";
            }else{
                $this->setMessages("Tags parameters are not valid");
                $i = $sizeArg;
            }
        }
    }

    public function setFileArray($fileArray)
    {
        $this->fileArray = $fileArray;
    }

    public function getFileArray()
    {
        return $this->fileArray;
    }

    public function setDirPath($dirPath)
    {
        $this->dirPath = $dirPath;
    }

    public function getDirPath()
    {
        return $this->dirPath;
    }

    public function setMessages($messages)
    {
        $this->messages[] = $messages;
    }

    public function getMessages()
    {
        return $this->messages;
    }

    public function setTotFiles($totFiles)
    {
        $this->totFiles = $totFiles;
    }

    public function getTotFiles()
    {
        return $this->totFiles;
    }

    public function setTotPhpFiles($totPhpFiles)
    {
        $this->totPhpFiles = $totPhpFiles;
    }

    public function getTotPhpFiles()
    {
        return $this->totPhpFiles;
    }
    public function setArguments($arguments)
    {
        $this->arguments = $arguments;
    }

    public function getArguments()
    {
        return $this->arguments;
    }

    public function setTotArguments($totArguments)
    {
        $this->totArguments = $totArguments;
    }

    public function getTotArguments()
    {
        return $this->totArguments;
    }

    public function setFilePhpArray($filePhpArray)
    {

        $this->filePhpArray[] = $filePhpArray;
    }

    public function getFilePhpArray()
    {
        return $this->filePhpArray;
    }

    public function setTags($tags)
    {
        $this->tags[] = $tags;
    }

    public function getTags()
    {
        return $this->tags;
    }
}
