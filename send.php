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
		}elseif ($_POST['submitcode'] ) {
			
			$code = $_POST['code'];
			echo $code;
		}
			
			$codec = new CommentCheck($code);
			$codec->verify();
			print_r($codec->getErrors());
	
 