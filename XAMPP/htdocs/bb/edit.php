<?php
// edit.php
include("include.php"); // <--- IMPORTANT!!! this file contains basic setup for our app's global features used on every page

$msg =NULL;
if ($_SERVER["REQUEST_METHOD"] == "POST") { // check that POST data was submitted
        
  $msg = $_POST['msg'];
 
  if ( empty($msg) ) { // check that necessary values were submitted
    header("Location: main.php"); // redirect to main page in case of error
  }
}else{
  header("Location: main.php"); // redirect to main page in case of error
}

/*
Toiminto:
Viestin muokkaus

- lisätään lomake muokkaukseen:

*/
include("msgform.php");
$form = new msgform();
$formHTMLstr = $form->getMsgForm("editmsg.php", $msg);


?>
<!DOCTYPE html>
<html>
<head>
    <title>Keskustelut</title>
</head>
<body> <?php printMenu(); ?>
    <h1>Edit</h1>
    
    <?php 

    echo $formHTMLstr;

?>


</body>
</html>