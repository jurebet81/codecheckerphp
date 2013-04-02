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
    private $messages;
    private $arguments;
    private $totArguments;
    private $filesAux;

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
        if ( $this->getTotArguments() > 2){
            if ( $this->arguments[1] == "f"){
                $this->orderByFiles( $this->getArguments());
            } else if ($this->arguments[1] == "d") {
                $this->orderByDirectory( $this->getArguments());
            }else {
                $this->setMessages("Parametro no valido");
            }
        }else{
            $this->setMessages("No hay suficientes argumentos para el chequeo");
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
        $this->setTotFiles( sizeof( $this->getFileArray()) - 2);
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

    private function orderByDirectory($directory){
        if ( is_dir( $directory[2])){
            $this->setDirPath( $directory[2] . "/");
            $this->loadAllFiles( $this->getDirPath());
            $this->loadPhpFiles( $this->getFileArray());
        }else{
            $this->setMessages( $directory[2] . " No es un directorio") ;
        }
    }

    private function orderByFiles($files){
        $this->setDirPath("");
        for ( $i = 2; $i < $this->getTotArguments(); $i++){
            echo $files[$i];
            if ( is_file( $files[$i])) {
                $this->setFilesAux( $files[$i]);
            }else{
                $this->setMessages( $files[$i] . " No es un archivo");
            }
        }
        if ( sizeof( $this->getFilesAux()) > 0){
            $this->setTotFiles( sizeof( $this->getFilesAux()));
            $this->setFileArray( $this->getFilesAux());
            $this->loadPhpFiles( $this->getFilesAux());
        }else{
            $this->setMessages("Hubo un error obteniendo los archivos a analizar");
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
    public function setFilesAux($filesAux)
    {
        $this->filesAux[] = $filesAux;
    }

    public function getFilesAux()
    {
        return $this->filesAux;
    }
}
