<?php
$uname = $_SESSION["username"];
if($_SERVER["REQUEST_METHOD"] == "POST"){
    $newContent = $_POST['msg'];
    $newTitle = $_POST['title'];
    $msgID = $_POST['msgid'];
}


?>