<?php
session_start(); // start PHP session to remember user login info across page loads
if ($_SERVER["REQUEST_METHOD"] == "POST") { // check that POST data was submitted
  // collect value of input field
  $name = $_POST['username'];
  $pass = $_POST['password'];
  
  if (empty($name) || empty($pass)) { // check that necessary values were submitted
    header("Location: index.php"); // redirect to login form in case of error
  } 
}else{
  header("Location: index.php"); // redirect to login form in case of error
}

/* OK to proceed checking usert login  */

include("db.php");

$dbHost = 'localhost';
$dbUser = 'root';
$dbPass = '';
$dbDatabase = 'bb';

$database = new db($dbHost,$dbUser,$dbPass,$dbDatabase,'utf8'); // initilize database connection

$queryStr = "SELECT * FROM user WHERE username = '" . $name . "' AND password LIKE '" . $pass . "' LIMIT 1; ";
// string above constructed: "SELECT * FROM user WHERE username = 'anton' AND password LIKE 'anton1' LIMIT 1; "

$userData = $database->query($queryStr); // execute query and store results in $db object userData

if($userData->numRows()){ // check if a result was found
  // user found - SUCCESS!
  //echo "WELCOME $name";

  $_SESSION["username"] = $name; // store credentials for future page loads...
  $_SESSION["password"] = $pass;
  header("Location: main.php"); // redirect to main page in case of succesfull login

}else{
  // failed attempt
  header("Location: index.php"); // redirect to login form in case of user not found from database
}


?>