<html>
<head>
<link rel="stylesheet" href="diseno.css" type="text/css" />
</head>
</body>			
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
		echo("You must select at least one parameter");
				
	}else{
	$vectorparams =$_POST['checks'];
	$codec = new CommentCheck($code,$vectorparams);
	$codec->verify();
		
			
		echo '<textarea class="codearea">';
				foreach($codec->getCodeArray() as $codeArray){
					echo $codeArray ."\n" ;
				}
		echo "</textarea>";
		
		if(sizeof($codec->getErrors())>0){
				echo "<ul>";
				foreach($codec->getErrors() as $errorArray){
					echo "<li>";
					echo $errorArray ;
					echo "</li>";
				}
				echo "</ul>";
		}else {
			echo "The file is correctly commented";
		}
		echo "1.  The title tag if is being checked must be the first tag of the comment;

			2.  The correct structure of the comment is;
				/**;
				 *;
				 *;
				 */";

				


		
}
?>
</body>
</html>	