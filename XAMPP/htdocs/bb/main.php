<!-- include 'db.php';

$dbhost = 'localhost';
$dbuser = 'root';
$dbpass = '';
$dbname = 'example';

$db = new db($dbhost, $dbuser, $dbpass, $dbname, 'utf8');
$queryStr = "SELECT id, title, author from thread WHERE 1; ";

$count =  -->
<?php
// Database connection parameters
$hostname = 'localhost';
$username = 'root';
$password = ''; // Your database password (if any)
$database = 'bb';

// Author ID to filter threads
$sql = "SELECT id FROM user WHERE username = $username";

// $authorId = SELECT id FROM `user` WHERE 1; // Replace with the desired author ID

// Create a new mysqli connection
$mysqli = new mysqli($hostname, $username, $password, $database);

// Check for connection errors
if ($mysqli->connect_error) {
    die("Connection failed: " . $mysqli->connect_error);
}

// SQL query to select titles from the 'thread' table for a specific author ID
$sql = "SELECT title FROM thread WHERE author = ?";

// Prepare the statement
$stmt = $mysqli->prepare($sql);

// Bind the parameter (author ID) to the statement
$stmt->bind_param("i", $authorId);

// Execute the query
if ($stmt->execute()) {
    // Bind the result
    $stmt->bind_result($title);

    // Fetch and print the titles
    while ($stmt->fetch()) {
        echo $title . "<br>";
    }

    // Close the statement
    $stmt->close();
} else {
    echo "Error: " . $mysqli->error;
}

// Close the database connection
$mysqli->close();
?>