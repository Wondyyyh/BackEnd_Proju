<?php
// delmsg.php - oman viestin poisto 

include("include.php"); // <--- IMPORTANT!!! this file contains basic setup for our app's global features used on every page

$msgId=0;
$userID=0;

	if ($_SERVER["REQUEST_METHOD"] == "POST") { // check that GET data was submitted
	  
	  $msgId = $_POST['msg'];
	  
	  if (empty($msgId)) { // check that necessary values were submitted
	    header("Location: main.php"); // redirect to main page in case of error
	  } 
	}else{
	  header("Location: main.php"); // redirect to main page in case of error
	}

    $usrQueryStr = "SELECT id FROM user WHERE username = '" . $_SESSION["username"] . "' LIMIT 1;";
    
    $usrData = $database->query($usrQueryStr); // execute query and store results 

    $count = $usrData->numRows();

    if($count){ // check if a result was found
    	$results = $usrData->fetchAll();
    	$userID = $results[0]['id'];
    }else{
    	header("Location: main.php");
    }
    
    $delQueryStr = "UPDATE `msg` SET hidden=TRUE WHERE id = '" . $msgId . "' AND author = '".$userID."';"; 
	
	$delData = $database->query($delQueryStr); // execute query and store results 

    $count = $delData->numRows();

    if($count){ // check if a result was found, react if necessary
    }else{
    	// react to failure if necessary
    }
    header('Location: ' . $_SERVER['HTTP_REFERER']); // bit unsafe but dirty&working redirect back to previous page

?>