<?php
include 'CommentCheckClass.php';
 /**
 * Created by JetBrains PhpStorm.
 * User: User
 * Date: 3/17/13
 * Time: 9:36 PM
 * To change this template use File | Settings | File Templates.
 */
    if (isset ( $_POST ['submitfile'] )) {
         if (isset ( $_FILES ['file'] ) && is_uploaded_file ( $_FILES ['file'] ['tmp_name'] )) {
                chmod($_FILES['file']['tmp_name'], 0444);
                $code=file_get_contents($_FILES['file']['tmp_name']);
        }
    }else if (($_POST['submitcode'] )) {
            $code = $_POST['code'];
    }

	if (empty ($_POST['checks'])) {			
		echo("debe seleccionar al menos un parametro");
				
	}else{
	$vectorparams =$_POST['checks'];
	$codec = new CommentCheck($code,$vectorparams);
	$codec->verify();
	
		if(sizeof($codec->getErrors())>0){
				print_r($codec->getErrors());
		}else {
			echo "The file is correctly commented";
    }
		
}
	