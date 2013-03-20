<?php
/**
 * Created by Julian Restrepo
 * User: Julian
 * Date: 3/18/13
 * Time: 1:40 PM
 * To change this template use File | Settings | File Templates.
 */
include 'CommentCheckClass.php';
include 'SortFilesClass.php';

    $sortFiles = new SortFiles($argv);
    $sortFiles->startSorting();
    if ( sizeof( $sortFiles->getMessages()) == 0){
        for ( $i = 0; $i < $sortFiles->getTotPhpFiles(); $i++){
            $ccode = new CommentCheck( file_get_contents( $sortFiles->getDirPath() .$sortFiles->filePhpArray[$i]));
            $ccode->verify();
            if ( sizeof( $ccode->getErrors()) > 0){
                echo "\n The file: " . $sortFiles->filePhpArray[$i] . " has the following errors: ";
                print_r ( $ccode->getErrors());

            }else {
                echo "\n The file: " . $sortFiles->filePhpArray[$i] . " is correctly commented";
            }

        }

}   else{
        echo print_r( $sortFiles->getMessages());
    }

