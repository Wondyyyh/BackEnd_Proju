<?php
session_start();
if(!isset($_SESSION["username"]))
{
	// user not logged in, redirect to index.php
	header("Location: index.php");
}else{

    include("db.php");

    $dbHost = 'localhost';
    $dbUser = 'root';
    $dbPass = '';
    $dbDatabase = 'bb';

    $database = new db($dbHost,$dbUser,$dbPass,$dbDatabase,'utf8'); // initilize database connection

    $queryStr = "SELECT thread.id AS id, title, author, username FROM thread, user WHERE thread.author=user.id; ";

    $listingStr="<ul>";

    $threadData = $database->query($queryStr); // execute query and store results 
    $count = $threadData->numRows();
    if($count){ // check if a result was found
        $results = $threadData->fetchAll();
        foreach($results as $singleRes){
            
            $authorName = $singleRes['username'];
            $thrTitle = $singleRes['title'];
            $thrId = $singleRes['id'];

            $linkStr = "<a href='thread.php?id=" . $thrId . "' >" . $thrTitle . "</a>";
            $listingStr .= "<li> Kirjoittaja: " . $authorName . " - Aihe: " . $linkStr . "</li>";
        }

        $listingStr .= "</ul>";

    }else{
      echo "<h1>Keskusteluja ei ole</h1>";
    }

/*
Toiminto:
A) Uuden keskustelun aloitus

- lisätään lomake keskustelun luomiseen:

*/
include("msgform.php");
$form = new msgform();
$formHTMLstr = $form->getMsgForm("newthread.php");


?>
<!DOCTYPE html>
<html>
<head>
    <title>Keskustelut</title>
</head>
<body>
    <h1>Keskustelut</h1>
    
    <?php echo $listingStr;

    echo $formHTMLstr;

}// end of else block


?>


</body>
</html>