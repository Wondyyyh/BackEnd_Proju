<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Tarkista kirjautuminen ja hae käyttäjän tiedot, esimerkiksi käyttäjänimen perusteella.
    // $username = $_POST['username']; // Tässä vaiheessa voit käyttää oikeaa kirjautumistarkistusta.

    // Oletetaan, että olet kirjautunut ja tiedät käyttäjänimen.
    // Voit vaihtaa tätä osaa käyttämään oikeaa kirjautumistarkistusta.

    // Yhdistä tietokantaan (korvaa tiedot omilla tiedoillasi).

    include("db.php"); //<----- Database connect check starts here

    $dbHost = 'localhost';
    $dbUser = 'root';
    $dbPass = '';
    $dbDatabase = 'bb';

    $database = new db($dbHost, $dbUser, $dbPass, $dbDatabase, 'utf8'); // initilize database connection


    // string above constructed: "SELECT * FROM user WHERE username = 'anton' AND password LIKE 'anton1' LIMIT 1; "
    $userQueryStr = "SELECT id FROM user WHERE username = '" . $_SESSION["username"] . "' LIMIT 1; ";
    $userData = $database->query($userQueryStr); // Execute query and store results

    $count = $userData->numRows();
    if($count){
        $results = $userData->fetchAll();
        $user_id = $results[0]['id'];
    }

    // Talleta uusi keskusteluavaus
    $db->beginTransaction();

    // Insert-kysely uuden keskusteluavauksen lisäämiseksi
    $insertThreadSQL = "INSERT INTO 'thread' ('title','author') VALUES ('".$title."', '".$user_id."');";

    $insertResults = $database->query($insertThreadSQL);
    if($insertResults->affectedRows()){
        header("Location: main.php");
    }
    else{
        $threadId = $insertResults->lastInsertID();
        $insertMessageSQL = "INSERT INTO 'msg' ('thread', 'title', 'content', 'author') VALUES"
        . " ('".$threadId."', '".$title."', '".$msg."', '".$user_id."') ";


        $database->query($insertMessageSQL);
        header("Location: thread.php?id=$threadId"); //redirect to new thread page
    }

    $stmt = $db->prepare($insertThreadSQL);
    $stmt->execute(array(':user_id' => $user_id));


   
    // Insert-kysely aloitusviestin lisäämiseksi
    $message = $_POST['message'];
    $insertMessageSQL = "INSERT INTO msg (thread.id, author, message) VALUES (:thread_id, :user_id, :message)";
    $stmt = $db->prepare($insertMessageSQL);
    $stmt->execute(array(':thread_id' => $threadId, ':user_id' => $user_id, ':message' => $message));

    $db->commit();

    echo "Uusi keskusteluavaus on luotu!";
} else {
    echo "Virhe: Pyyntö ei ole POST-menetelmä.";
}
?>