<?php
// Database connection
$conn = new mysqli('localhost', 'root', '', 'E-TRACK');

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$id = intval($_POST['id']);

// Delete transaction
$sql = "DELETE FROM transactions WHERE id = $id";
if ($conn->query($sql) === TRUE) {
    echo json_encode(['status' => 'success']);
} else {
    echo json_encode(['status' => 'error']);
}

$conn->close();
?>
