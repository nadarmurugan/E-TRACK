<?php
session_start();

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "E-TRACK";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$userId = $_SESSION['user_id'];

// Delete user profile
$sql = "DELETE FROM users WHERE id=?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $userId);

if ($stmt->execute()) {
    echo json_encode(['success' => 'Profile deleted successfully.']);
} else {
    echo json_encode(['error' => 'Error deleting profile.']);
}

$stmt->close();
$conn->close();
?>
