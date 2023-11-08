<?php

include("include.php"); // <--- IMPORTANT!!! this file contains basic setup for our app's global features used on every page


    $queryStr = "SELECT thread.id AS id, title, author, username FROM thread, user WHERE thread.author=user.id AND thread.hidden=FALSE; ";
 

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

            $listingStr .= 
            "<li> Kirjoittaja: " . 
            $authorName . " - Aihe: " . 
            $linkStr .           
            "</li>";
        }

        $listingStr .= "<br/>" .
        "</ul>";

    }else{
      echo "<h1>Keskusteluja ei ole</h1>";
    }

/*
Toiminto:
Uuden keskustelun aloitus

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
<body> <?php printMenu(); ?>
    <h1>Keskustelut</h1>
    
    <?php echo $listingStr;

    echo $formHTMLstr;

?>


</body>
</html>