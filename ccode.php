<?php
/**
 * Created by Julian Restrepo
 * User: Julian
 * Date: 3/18/13
 * Time: 1:40 PM
 * To change this template use File | Settings | File Templates.
 */
include 'CommentCheckClass.php';


$arg0 = $argv[0];
$arg1 = $argv[1];
$numArgs = sizeof($argv) - 1;

if ($arg1 == "f"){
     echo "file";

}else if ($arg1 =="d"){
    $dirPath = $argv[2];
    $files = scandir($dirPath);
    $numFiles = sizeof($files);
    for ($i=2;$i<$numFiles;$i++ ){
        $ccode = new CommentCheck(file_get_contents($dirPath . "/" .$files[$i]));
        $ccode->verify();
        if (sizeof($ccode->getErrors()) > 0){
            echo "The file: " . $files[$i] . " has the following errors: ";
            print_r ($ccode->getErrors());
        }else {
            echo sizeof($ccode->getErrors());
            echo "The file: " . $files[$i] . " is correctly commented";
        }


    }
}