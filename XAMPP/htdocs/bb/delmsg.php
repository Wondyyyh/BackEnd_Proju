<?php
// delmsg.php - oman viestin poisto / kohta C)
session_start();
$msgId=0;
if(!isset($_SESSION["username"]))
{
	// user not logged in, redirect to index.php
	header("Location: index.php");
}
else{
	/* TO DO: fetch all messages of this thread and display in order neatly  */
	if ($_SERVER["REQUEST_METHOD"] == "POST") 
    { // check that GET data was submitted
	  
	  $msgId = $_GET['msg'];
	  
	  if (empty($msgId)) { // check that necessary values were submitted
	    header("Location: main.php"); // redirect to main page in case of error
	  } 
	}
    else{
	  header("Location: main.php"); // redirect to main page in case of error
	}

	include("db.php");

    $dbHost = 'localhost';
    $dbUser = 'root';
    $dbPass = '';
    $dbDatabase = 'bb';

    $database = new db($dbHost,$dbUser,$dbPass,$dbDatabase,'utf8'); // initilize database connection

    $delQueryStr = "UPDATE `msg` SET hidden='TRUE' WHERE id = ".$msgId.");"; // TODO: finalize user comparison...
}?>