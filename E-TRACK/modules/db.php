<?php
// Database configuration
$servername = "localhost";
$username = "root";  // Use your DB username
$password = "";      // Use your DB password
$dbname = "E-TRACK";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>
