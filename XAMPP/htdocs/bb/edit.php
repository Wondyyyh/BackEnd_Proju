<?php
//edit.php

// include("include.php");

$msg = NULL;
if($_SERVER["REQUEST_METHOD"]== "POST"){

    $msg = $_POST['msg'];
    if(empty($msg)){
       header("Location: main.php");
    }
}
else header("Location: main.php");

include("msgform.php");
$form = new msgform();
$formHTMLstr = $form->getMsgForm("editmsg.php", $msg);


?>
<!DOCTYPE html>
<html>
    <head>
        <title>Keskustelut</title>
    </head>
    <body>
        <?php printMenu(); ?>
        <h1>Edit</h1>

        <?php
            echo $formHTMLstr;
        ?>


    </body>
</html>