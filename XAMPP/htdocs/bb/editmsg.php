<?php
//editmsg.php
include("include.php"); // <--- IMPORTANT!!! this file contains basic setup for our app's global features used on every page
	
$uname = $_SESSION["username"];

if ($_SERVER["REQUEST_METHOD"] == "POST") { // check that GET data was submitted
  
  $newContent = $_POST['msg'];
  $newTitle = $_POST['title'];
  $msgID = $_POST['msgid'];
  
  
  if (empty($msgID) ) { // check that necessary values were submitted
    	header("Location: main.php"); // redirect to main page in case of error   
	}
}else{
  header("Location: main.php"); // redirect to main page in case of error
}

$queryStr = "UPDATE `msg` SET title='".$newTitle."',"
    ." content='".$newContent."',"
    ." modified=CURRENT_TIMESTAMP() "
    ." WHERE id = '".$msgID."';";
    
	$usrData = $database->query($queryStr); // execute query and store results 

    $count = $usrData->numRows();

    if($count){ // check if a result was found

    	// reaction?
	}
	header("Location: main.php");


?>