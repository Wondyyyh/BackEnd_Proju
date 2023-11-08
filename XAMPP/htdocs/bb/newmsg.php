<?php
// newmsg.php

/*
Toiminto:
Uuden keskustelun aloitus

- vastaanottaa sivun thread.php lomakkeelta msgform tiedot post-pyyntönä.
- luo ketjuun uuden viestin.
- ohjaa navigaation ketjun sivulle 

*/
include("include.php"); // <--- IMPORTANT!!! this file contains basic setup for our app's global features used on every page

$threadID=0;
$id=0;

	if ($_SERVER["REQUEST_METHOD"] == "POST") { // check that POST data was submitted
	  
	  $title = $_POST['title'];
	  $msg = $_POST['msg'];
	  $threadID = $_POST['thread'];
	  
	  if (empty($title) || empty($msg) || empty($threadID)) { // check that necessary values were submitted
	    header("Location: main.php"); // redirect to main page in case of error
	  }elseif((empty($title) || empty($msg)) && $threadID) {
	  	header("Location: thread.php?id=".$threadID); // redirect to thread page if msg/title missing
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

    	// *** Create new message to the  thread:
    	
    	$insertMsgQuery = "INSERT INTO `msg` (`thread`, `title`, `content`, `author`) VALUES "
    		. " ('$threadID', '$title', '$msg', '$userID') ";
    	$insertResults = $database->query($insertMsgQuery); // TODO: check success and create error message?

    	header("Location: thread.php?id=$threadID"); // redirect to thread page
    	
    }
    header("Location: main.php"); // redirect to main page in case of error (user not found)



?>