<?php

/*
Toiminto:
Uuden keskustelun aloitus

- vastaanottaa sivun main.php lomakkeelta msgform tiedot post-pyyntönä.
- luo uuden keskusteluketjun sekä siihen liittyvän uuden viestin.
- ohjaa navigaation uuden ketjun sivulle jos lisäys onnistuu.

*/

include("include.php"); // <--- IMPORTANT!!! this file contains basic setup for our app's global features used on every page

$id=0;

	/* TO DO: fetch all messages of this thread and display in order neatly  */
	if ($_SERVER["REQUEST_METHOD"] == "POST") { // check that POST data was submitted
	  
	  $title = $_POST['title'];
	  $msg = $_POST['msg'];
	  
	  if (empty($title) || empty($msg)) { // check that necessary values were submitted
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

    	// *** 1) Create new thread/topic and get its id for adding a message to it:

    	// INSERT INTO `thread` (`id`, `title`, `author`, `created`, `hidden`) VALUES (NULL, 'fghf hg hg g', '1', current_timestamp(), '0');

    	$insertThrQuery = "INSERT INTO `thread` (`title`, `author`) VALUES ('".$title."', '".$userID."'); ";
    	echo $insertThrQuery."<br>";
    	$insertResults = $database->query($insertThrQuery);
    	if(!$insertResults->affectedRows()) {
    		// failure in thread insertion, continue with nothing
    		header("Location: main.php"); // redirect to main page in case of error
    	}
    	else {
    		// *** 2) Create new message to the new thread:
    		$threadID=$insertResults->lastInsertID();
    		$insertMsgQuery = "INSERT INTO `msg` (`thread`, `title`, `content`, `author`) VALUES "
    			. " ('".$threadID."', '".$title."', '".$msg."', '".$userID."') ";
    			
    		$database->query($insertMsgQuery);
    		header("Location: thread.php?id=$threadID"); // redirect to thread page
    	}


    }
    header("Location: main.php"); // redirect to main page in case of error



?>
