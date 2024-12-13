<?php
// db_connection.php
$conn = new mysqli("localhost", "root", "", "voting_system");

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>
