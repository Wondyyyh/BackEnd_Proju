<?php
include("include.php"); // <--- IMPORTANT!!! this file contains basic setup for our app's global features used on every page

$id=0;
$thrAuthorUserId = 0;
$msgCount=0;

	/* fetch all messages of this thread and display in order neatly  */

	if ($_SERVER["REQUEST_METHOD"] == "GET") { // check that GET data was submitted
	  
	  $id = $_GET['id'];
	  
	  if (empty($id)) { // check that necessary values were submitted
	    header("Location: main.php"); // redirect to main page in case of error
	  } 
	}else{
	  header("Location: main.php"); // redirect to main page in case of error
	}


    //  Oman viestin poistoa varten haetaan ensin käyttäjän tunniste (id) tietokannasta:
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

    $queryStr = "SELECT msg.id AS id, msg.title AS title, thread.title AS thrTit, msg.created AS created, content, username, user.id AS userid, thread.author AS thrAuth FROM msg, user, thread "
    			. " WHERE msg.author=user.id AND msg.thread = thread.id AND thread.id = ".$id." AND msg.hidden = FALSE ORDER BY msg.created ASC; ";

    $listingStr="<ul>";
    $thrTit = "";

    $threadData = $database->query($queryStr); // execute query and store results 

    $count = $threadData->numRows();
    if($count){ // check if a result was found
        $results = $threadData->fetchAll();
        foreach($results as $singleRes){
            $msgCount++; // keep track of message count
            
            $authorName = $singleRes['username'];
            $msgTitle = $singleRes['title'];
            $msgId = $singleRes['id'];
            $msgCont = $singleRes['content'];
            $msgCreat = $singleRes['created'];
            $thrTit =  $singleRes['thrTit'];
            $thrAuthorUserId = $singleRes['thrAuth'];

            $deleteStr=""; // string to contain deletion functionality
            $editStr="";

            $authorUserId =  $singleRes['userid']; // D) Oman viestin poisto
            if($authorUserId == $userID){
                // generate "Delete"-button/form
                $deleteStr .= '<form action = "delmsg.php" method = "POST"><input type="hidden" name="msg" id="msg" value="'.$msgId.'"><input type="submit" value="Delete"></form>';
                // generate edit button:
                $editStr .= '<form action = "edit.php" method = "POST"><input type="hidden" name="msg" id="msg" value="'.$msgId.'"><input type="submit" value="Edit"></form>';
            }

            $listingStr .= "<li> [ ". $msgCreat ." ] Kirjoittaja: " . $authorName . " - Aihe: " . $msgTitle 
            			. "<br/>"
            			. "<p>" . $msgCont . $deleteStr . $editStr . "</p>"
            			. "</li>";
        }

        $listingStr .= "</ul>";

    }else{
      $listingStr = "<h1>Keskusteluja ei ole</h1>";
    }


    /*
Toiminto:
 Uuden vastauksen lisäys ketjuun

- lisätään lomake viestin luomiseen:

*/
include("msgform.php");
$form = new msgform();
$form->addHidden('thread', $id);
$formHTMLstr = $form->getMsgForm("newmsg.php"); 

$delThrStr="";

// echo "thrAuthorUserId: " . $thrAuthorUserId . "<br>";
// echo "userID: " . $userID . "<br>";
// echo "result: " .($thrAuthorUserId == $userID) . "<br>";
// echo "msgCount: " . $msgCount . "<br>";

//Toiminto: koko ketjun poisto jos käyttäjä on author ja vastauksia ei ole (yksi viesti eli avausviesti sallitaan)
if($thrAuthorUserId == $userID && $msgCount <2){ 
    $delThrStr .= '<form action = "delthr.php" method = "POST">
    <input type="hidden" name="thrid" id="thrid" value="'.$id.'">
    <input type="submit" value="Delete thread"></form>';   
}

?>

<!DOCTYPE html>
<html>
<head>
    <title>Keskustelu</title>
</head>
<body> <?php printMenu(); ?>
    <h1>  <?php echo $thrTit; ?> ( <?php echo $msgCount; ?> viestiä)</h1>
    <div> <?php echo $delThrStr; ?>  </div>
    <div> <?php echo $listingStr; ?>  </div>
    <div><h2>Reply:</h2> <?php echo $formHTMLstr; ?>  </div>

</body>
</html>

<?php

?>