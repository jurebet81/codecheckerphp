<?php
/**
 * Created by Julian Restrepo
 * User: Julian
 * Date: 3/18/13
 * Time: 1:40 PM
 *
 */
include 'CommentCheckClass.php';
include 'SortFilesClass.php';

    $sortFiles = new SortFiles($argv);
    $sortFiles->startSorting();
    $totMessages = sizeof ($sortFiles->getMessages());
    if ( $totMessages == 0){
        for ( $i = 0; $i < $sortFiles->getTotPhpFiles(); $i++){
            $ccode = new CommentCheck( file_get_contents( $sortFiles->getDirPath() .$sortFiles->filePhpArray[$i]), $sortFiles->getTags());
            $ccode->verify();
            $totErrors = sizeof($ccode->getErrors());
            if ( $totErrors > 0){
                echo "\n\n The file: " . $sortFiles->filePhpArray[$i] . " has the following errors: ";
                $errors = $ccode->getErrors();
                for ($j=0; $j < $totErrors;$j++){
                    echo "\n  ". $j . " - " . $errors[$j] ;
                }
            }else {
                echo "\n\n The file: " . $sortFiles->filePhpArray[$i] . " is correctly commented";
            }
        }
    }else{
        $messages = $sortFiles->getMessages();
        for ($i=0; $i < $totMessages;$i++){
            echo "\n Error: " . $messages[$i];
        }
        $help = "ccode.php \n
            Sintax: php path/ccode.php [a | r | t | p] [f | d] PathOfDirectoryOrFile.php \n\n
            a:  check autor tag \n
            r:  check return tag \n
            t:  check title tag \n
            p:  check param tag \n \n
            f:  check specific files \n
            d:  check by a specific directory \n\n
            Example: php C:\\wamp\\www\\ccode.php art f codetobechecked.php";
        echo $help;
    }

