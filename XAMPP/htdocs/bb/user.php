<?php
// user.php
// maintain user information; list current and modify personal information
// use form 

include("include.php"); // <--- IMPORTANT!!! this file contains basic setup for our app's global features used on every page


	$uname = $_SESSION["username"];
	
    $queryStr = "SELECT * FROM user WHERE username = '" . $uname . "' LIMIT 1; ";

    $userData = $database->query($queryStr); // execute query and store results in $db object userData

	if($userData->numRows()){ // check if a result was found
		$results = $userData->fetchAll();
        foreach($results as $singleRes){
            
            $fname = $singleRes['firstname'];
            $lname = $singleRes['lastname'];
            $password = $singleRes['password'];

        }
	}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Omat tiedot</title>
</head>
<body>
	<?php printMenu(); ?>
    <h1>Päivitä tietosi</h1>
    <form action="upduser.php" method="post">
        <label for="username">Name:</label>
        <input type="text" id="username" name="username" required value="<?php echo $uname; ?>"><br><br>

        <label for="password1">Password:</label>
        <input type="password" id="password1" name="password1" required value="<?php echo $password; ?>"><br><br>

        <label for="password2">Password again:</label>
        <input type="password" id="password2" name="password2" required value="<?php echo $password; ?>" ><br><br>

        <label for="firstname">First name:</label>
        <input type="text" id="firstname" name="firstname" value="<?php echo $fname; ?>" ><br><br>

        <label for="lastname">Last name:</label>
        <input type="text" id="lastname" name="lastname" value="<?php echo $lname; ?>" ><br><br>

        <input type="submit" value="Submit">
    </form>

</body>
</html>
<?php


?>