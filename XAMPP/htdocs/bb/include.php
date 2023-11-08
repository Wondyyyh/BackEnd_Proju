<?php
// this script contains default init scripts used for every script to avoid multiple copies of boilerplate code

$database=NULL; // "global" database object initialized always and usable using the variable name $database where ever this is included

// set cache-control header:
header('Cache-Control: no-store, no-cache, must-revalidate, max-age=0');
header('Cache-Control: post-check=0, pre-check=0',false);

// set error reporting on for all messages:
ini_set('display_errors', '1');
ini_set('display_startup_errors', '1');
error_reporting(E_ALL);

// init session and grab basic user info or redirect to login page
session_start();

if(!isset($_SESSION["username"]))
{
	// user not logged in, redirect to index.php
	header("Location: index.php");
}else{
	// init database connection in case user is logged in.
	include("db.php");

    $dbHost = 'localhost';
    $dbUser = 'root';
    $dbPass = '';
    $dbDatabase = 'bb';

    $database = new db($dbHost,$dbUser,$dbPass,$dbDatabase,'utf8'); // initilize database connection

}

/* this prints out the menu of available optins on this site.*/
function printMenu() {
  global $isAdmin;

  if($isAdmin) {
    $userListEntry = '<a href="userlist.php">All users</a>';
  }
  else $userListEntry = "";
  echo '<div class="topnav">
  <a class="active" href="index.php">Login</a>
  <a href="main.php">Main</a>
  <a href="user.php">User</a>
  '.$userListEntry.'
  </div>';
  
  // <a href="newpage.php">Add Your Page Here</a> KÄYTÄ MYÖHEMMIN KUN TARVITAAN
}

$isAdmin = false;
$username = $_SESSION["username"];

$isAdminQuery = " SELECT isadmin FROM  `user` WHERE username LIKE '".$username."' AND isadmin = 1 LIMIT 1; ";
$usrData = $database->query($isAdminQuery);

$count = $usrData->numRows();
if($count){ // check if a result was found
  $isAdmin =true;
}


?>