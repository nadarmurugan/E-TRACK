<?php
// Database connection
$conn = new mysqli('localhost', 'root', '', 'E-TRACK');

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Query to get transactions
$sql = "SELECT * FROM transactions";
$result = $conn->query($sql);

$transactions = [];
while ($row = $result->fetch_assoc()) {
    $transactions[] = $row;
}

echo json_encode($transactions);

$conn->close();
?>
