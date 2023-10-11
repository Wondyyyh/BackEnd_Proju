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

    $queryStr = "SELECT msg.id AS id, msg.title AS title, thread.title AS thrTit, msg.created AS created, content, username FROM msg, user, thread "
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

            $listingStr .= "<li> [ ". $msgCreat ." ] Kirjoittaja: " . $authorName . " - Aihe: " . $msgTitle 
            			. "<br/>"
            			. "<p>" . $msgCont . "</p>"
            			. "</li>";
        }

        $listingStr .= "</ul>";

    }else{
      $listingStr = "<h1>Keskusteluja ei ole</h1>";
    }


?>

<!DOCTYPE html>
<html>
<head>
    <title>Keskustelu</title>
</head>
<body>
    <h1>  <?php echo $thrTit; ?> </h1>
    <div> <?php echo $listingStr; ?>  </div>

</body>
</html>

<?php
}
?>