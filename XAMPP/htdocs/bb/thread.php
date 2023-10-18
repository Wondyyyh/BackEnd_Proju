<?php
session_start();
$id=0;
if(!isset($_SESSION["username"]))
{
	// user not logged in, redirect to index.php
	header("Location: index.php");
}else{
	/* TO DO: fetch all messages of this thread and display in order neatly  */
	if ($_SERVER["REQUEST_METHOD"] == "GET") { // check that GET data was submitted
	  
	  $id = $_GET['id'];
	  
	  if (empty($id)) { // check that necessary values were submitted
	    header("Location: main.php"); // redirect to main page in case of error
	  } 
	}else{
	  header("Location: main.php"); // redirect to main page in case of error
	}

	include("db.php");

    $dbHost = 'localhost';
    $dbUser = 'root';
    $dbPass = '';
    $dbDatabase = 'bb';

    $database = new db($dbHost,$dbUser,$dbPass,$dbDatabase,'utf8'); // initilize database connection

    // D) Oman viestin poistoa varten haetaan ensin käyttäjän tunniste (id) tietokannasta:
    $usrQueryStr = "SELECT id FROM user WHERE username = '" . $_SESSION["username"] . "' LIMIT 1;";
    $usrData = $database->query($usrQueryStr); // execute query and store results 

    $count = $usrData->numRows();
    if($count){ // check if a result was found
        $results = $usrData->fetchAll();
        $userID = $results[0]['id'];
    }else{
        $userID = NULL; // should not happen
    }

    // lets fetch all messages from database:

    $queryStr = "SELECT msg.id AS id, msg.title AS title, thread.title AS thrTit, msg.created AS created, content, username, user.id AS userid FROM msg, user, thread "
    			. " WHERE msg.author=user.id AND msg.thread = thread.id AND thread.id = ".$id." ORDER BY msg.created ASC; ";

    $listingStr="<ul>";
    $thrTit = "";

    $threadData = $database->query($queryStr); // execute query and store results 

    $count = $threadData->numRows();
    if($count){ // check if a result was found
        $results = $threadData->fetchAll();
        foreach($results as $singleRes){
            
            $authorName = $singleRes['username'];
            $msgTitle = $singleRes['title'];
            $msgId = $singleRes['id'];
            $msgCont = $singleRes['content'];
            $msgCreat = $singleRes['created'];
            $thrTit =  $singleRes['thrTit'];

            $deleteStr=""; // string to contain deletion functionality
            $authorUserId =  $singleRes['userid']; // D) Oman viestin poisto
            if($authorUserId == $userID){
                // generate "Delete"-button/form
                $deleteStr .= '<form action = "delmsg.php" method = "POST"><input type="hidden" name="msg" id="msg" value="$msgId"><input type="submit" value="Delete"></form>';
            }

            $listingStr .= "<li> [ ". $msgCreat ." ] Kirjoittaja: " . $authorName . " - Aihe: " . $msgTitle 
            			. "<br/>"
            			. "<p>" . $msgCont . $deleteStr . "</p>"
            			. "</li>";
        }

        $listingStr .= "</ul>";

    }else{
      $listingStr = "<h1>Keskusteluja ei ole</h1>";
    }


    /*
Toiminto:
B) Uuden vastauksen lisäys ketjuun

- lisätään lomake viestin luomiseen:

*/
include("msgform.php");
$form = new msgform();
$form->addHidden('thread', $id);
$formHTMLstr = $form->getMsgForm("newmsg.php"); 


?>

<!DOCTYPE html>
<html>
<head>
    <title>Keskustelu</title>
</head>
<body>
    <h1>  <?php echo $thrTit; ?> </h1>
    <div> <?php echo $listingStr; ?>  </div>
    <div><h2>Reply:</h2> <?php echo $formHTMLstr; ?>  </div>

</body>
</html>

<?php
}
?>