<?php
// userlist.php - page for admin users to list and manage users; upgrading to admin, blocking access, modifying information

// modify database for storing admin level, e.g. by adding new column: 
// ALTER TABLE `user` ADD `isadmin` BOOLEAN NOT NULL DEFAULT FALSE AFTER `banned`; 

// step by step instructions:

// INITIALIZING PAGE / CHECKING ACCESS RIGHTS (only admins should be able to enter)

include("include.php");

// 0) include "include.php" to add and execute basic init perrocedures, and check login (username for session defined, see other source files)
// 1) based on the username in $_SESSION superglobal variable, do a database query to check if user is admin. Redirect using header() if not.

if(!$isAdmin){
	header("Location: main.php");
}

$outPutStr="";

// PREPARING DATA TO BE USED

// 2) for logged admins, create a SELECT query as a string that gets ALL USERS from database
// 3) execute query by using $database->query() -method (see examples from other source files)
// 4) check the succession by getting number of result rows and if necessary, redirect away upon error

$allUsersQuery = "SELECT * FROM `user` WHERE 1; ";

$usrData = $database->query($allUsersQuery);
$count = $usrData->numRows();
if(!$count){ // check if a result was found
  $outPutStr="<h1>Ei käyttäjiä!</h1>";
}else{

// DISPLAYING DATA AND ADDING USER MANAGEMENT FUNCTIONALITY

// 5) iterate through all result rows and generate e.g. a HTML table <tr><td>content</td><td>contentalso</td></tr> from the result rows
//    use numRows(), fetchAll() and foreach-loop, see other source files for example

	$results = $usrData->fetchAll();
	$outPutStr .= "<table>";
	foreach($results as $singleRes){
		$userName = $singleRes['username'];
		$userID = $singleRes['id'];
		$firstName = $singleRes['firstname'];
		$lastName = $singleRes['lastname'];
		$banned = $singleRes['banned'];
		$isUserAdmin = $singleRes['isadmin'];

		$outPutStr .= "<tr>";

		$outPutStr .= "<td>".$userName."</td>";
		$outPutStr .= "<td>".$firstName."</td>";
		$outPutStr .= "<td>".$lastName."</td>";

		$banButtonText="Ban!";
		if($banned) $banButtonText="Unban!";

		$banButton = 
        '<form action = "ban.php" method = "POST">
        <input type="hidden" name="user" id="user" value="'.$userID.'">
        <input type="submit" value="'.$banButtonText.'">
        </form>';
        
		$outPutStr .= "<td>".$banButton."</td>";

		$outPutStr .= "</tr>";
	}
	$outPutStr .= "</table>";

// 6) while generating the table, add also separate columns (<td>) for action buttons; upgrade/downgrade, ban, edit:
//    first button should alter its label (upgrade/downgrade) based on users actual role at the moment and trigger separate management script for role change
//    ban-button should trigger separate management script that sets "banned" column as TRUE (use e.g. delmsg.php as an example)
//    edit-button should redirect to user.php and display personal information of the user to be edited
//       -> this requires modifying user.php (accepting user-id as a POST-argument instead of using SESSION of the actual user)
//           and corresponging additional hidden input into the form for conveying user-id to the server-side manager script again (upduser.php)
//           so that admins can edit others' information too, not just their own

}

// 6b) create the necessary manager scripts to do database updates based on the POST requests from the previous buttons
//     HINT: create separate small form for each button and use hidden inputs to convey variables - see other source code for examples


// UTILIZE NEW FEATURES IN OTHER FUNCTIONALITIES TOO

// 6c) also modify relevant other sources to take into account user ban and role:
//     - disable login for banned users
//     - allow admins to delete and edit ALL messages and threads regardless of who is their author or if there are replies to a thread
//     - optional: allow admins to view also hidden messages and threads and reactivate them too (revert hiding, use similar mechanisms)
//         - show hidden content interleaved with visible one using e.g. color highlighting, or use completely separate list views for them

// 7) optional: make sure system always has one admin left, so don't allow downgrading or banning the last active admin user

?>

<!DOCTYPE html>
<html>
<head>
    <title>Käyttäjät</title>
</head>
<body> <?php printMenu(); ?>
    <h1> Käyttäjät </h1>
    <div> <?php echo $outPutStr; ?></div>

</body>
</html>