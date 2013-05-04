<html>
    <head>
        <link rel="stylesheet" href="Styles/diseno.css" type="text/css" />
    </head>
    <body>
    <div id="pageHeader">
        <h1><span>CODE COMMENTS CHECKER</span></h1>
        <h2>ESCUELA DE INGENIERIA DE ANTIOQUIA</h2>
        <p>By: Andrea H, Christian H, Juli&aacuten R, Marcela J, Manuel T.</p>
        <h4>Teacher: Santiago Villegas.</h4>
    </div>
    <div id="container">
        <?php
            include 'CommentCheckClass.php';
            include 'ReportErrorClass.php';
            function inverse($x){
                throw new Exception('mucho voltage');
            }
            if (isset ( $_POST ['submitfile'] )) {
                if ($_FILES["file"]["error"] > 0){
                    echo 'subio mal';
                }else{
                    if (isset ( $_FILES ['file'] ) && is_uploaded_file ( $_FILES ['file'] ['tmp_name'] )) {
                         //var_dump($_FILES ['file']);
                         //if($_FILES['file']['type'] == "application/php"||$_FILES['file']['type'] == "text/php"){
                         $name=($_FILES ['file'] ['name'] );
                         $fileExtension = substr($name,strrpos( $name, '.' )+1);
                         if ($fileExtension == "php"){
                              chmod($_FILES['file']['tmp_name'], 0444);
                              $code=file_get_contents($_FILES['file']['tmp_name']);
                         }else{
                              echo 'Incorrect file.you must upload a php file';
                              exit;
                         }
                    }
                }
            }else if (($_POST['submitcode'] )) {
                $code = $_POST['code'];
            }
            if (!empty ($_POST['checks'])) {
                $vectorparams =$_POST['checks'];
                $numbercomments= $_POST['numbercomments'];
                $codec = new CommentCheck($code,$vectorparams,$numbercomments);
                $errorscode = sizeof($codec->getErrors());
                if ($errorscode > 1){
                    foreach($codec->getErrors() as $codeError){
                       echo $codeError ."\n" ;
                    }
                }else{
                    $codec->verify();
                    try{
                        inverse(0);
                    }
                    catch(Exception $e){
                        $error = new ReportError($e);
                    }
                    echo "<div id='contright'>";
                    echo '<textarea class="codearea">';
                    foreach($codec->getCodeArray() as $codeArray){
                        echo $codeArray ."\n" ;
                    }
                    echo "</textarea>";
                    echo "</div>";
                    echo "<div id='contleft'>";
                    if(sizeof($codec->getErrors())>0){
                        echo "<ul>";
                        foreach($codec->getErrors() as $errorArray){
                            echo "<li>" . $errorArray . "</li>";
                        }
                        echo "</ul>";
                    }else{
                        echo "<br>";
                        echo "The file is correctly commented";
                    }
                }
                echo "<p>1.  The title tag if is being checked must be the first tag of the comment;</p>
                         2.  The correct structure of the comment is;<br>
                            /** <br>
                             *<br>
                             *<br>
                             */<br>";
                echo "</div>";
            }
        ?>
    </div>
    </body>
</html>	