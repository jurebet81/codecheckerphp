<html>
<head>
<link rel="stylesheet" href="diseno.css" type="text/css" />
</head>
</body>			
<?php
include 'CommentCheckClass.php';
include 'ReportErrorClass.php';


 /**
 * Created by JetBrains PhpStorm.
 * User: User
 * Date: 3/17/13
 * Time: 9:36 PM
 * To change this template use File | Settings | File Templates.
 */
	
    if (isset ( $_POST ['submitfile'] )) {
         if (isset ( $_FILES ['file'] ) && is_uploaded_file ( $_FILES ['file'] ['tmp_name'] )) {
		 
				//if($_FILES['file']['type'] == "application/php"||$_FILES['file']['type'] == "text/php"){
					chmod($_FILES['file']['tmp_name'], 0444);
					$code=file_get_contents($_FILES['file']['tmp_name']);
				//}else{
					//exit;
				//}
        }
    }else if (($_POST['submitcode'] )) {
            $code = $_POST['code'];
    }

	if (empty ($_POST['checks'])) {			
				
	}else{
		$vectorparams =$_POST['checks'];
		$numbercomments= $_POST['numbercomments'];
		$codec = new CommentCheck($code,$vectorparams,$numbercomments);
		$codec->verify();
        
		
			
		echo '<textarea class="codearea">';
				foreach($codec->getCodeArray() as $codeArray){
					echo $codeArray ."\n" ;
				}
		echo "</textarea>";
		
		if(sizeof($codec->getErrors())>0){
				echo "<ul>";
				foreach($codec->getErrors() as $errorArray){
					echo "<li>" . $errorArray . "</li>";
				}
				echo "</ul>";
		}else {
			echo "The file is correctly commented";
		}
		
		echo "<p>1.  The title tag if is being checked must be the first tag of the comment;</p>

			2.  The correct structure of the comment is;<br>
				/** <br>
				 *<br>
				 *<br>
				 */<br>";
	
}
?>
</body>
</html>	