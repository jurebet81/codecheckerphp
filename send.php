<?php
include 'CommentCheckClass.php';
/**
 * Created by JetBrains PhpStorm.
 * User: User
 * Date: 3/17/13
 * Time: 9:36 PM
 * To change this template use File | Settings | File Templates.
 */
 if (isset ( $_POST ['submit'] )) {
	    if (isset ( $_FILES ['archivo'] ) && is_uploaded_file ( $_FILES ['archivo'] ['tmp_name'] )) {
			chmod($_FILES['archivo']['tmp_name'], 0444);
			$code=file_get_contents($_FILES['archivo']['tmp_name']);
			$codec = new CommentCheck($code);
			$codec->verify();
			print_r($codec->getErrors());
		}else{
			echo 'ese hp no subio';
		}

	}
