<?php
include 'CommentCheckClass.php';
/**
 * Created by JetBrains PhpStorm.
 * User: User
 * Date: 3/17/13
 * Time: 9:36 PM
 * To change this template use File | Settings | File Templates.
 */

$code = "blahblahbla";
$codec = new CommentCheck($code);
$codec->verify();
print_r($codec->getErrors();

