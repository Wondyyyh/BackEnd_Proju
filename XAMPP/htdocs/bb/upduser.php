<?php //upduser.php
include("include.php"); // <--- IMPORTANT!!! this file contains basic setup for our app's global features used on every page
	
	$uname = $_SESSION["username"];
	
	if ($_SERVER["REQUEST_METHOD"] == "POST") { // check that GET data was submitted
	  
	  $newUsername = $_POST['username'];
	  $newPass1 = $_POST['password1'];
	  $newPass2 = $_POST['password2'];
	  $newFname = $_POST['firstname'];
	  $newLname = $_POST['lastname'];
	  
	  if (empty($newUsername) || strcmp($newPass1, $newPass2)) { // check that necessary values were submitted
	    	header("Location: main.php"); // redirect to main page in case of error   
		}
	}else{
	  header("Location: main.php"); // redirect to main page in case of error
	}


    $queryStr = "UPDATE `user` SET username='".$newUsername."',"
    ." password='".$newPass2."',"
    ." firstname='".$newFname."',"
    ." lastname='".$newLname."'"
    ." WHERE username = '".$uname."';";
    
	$usrData = $database->query($queryStr); // execute query and store results 

    $count = $usrData->numRows();

    if($count){ // check if a result was found

    	// reaction?
	}
	header("Location: user.php");


?>

