<?php
// Database connection
$conn = new mysqli('localhost', 'root', '', 'E-TRACK');

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Query to get the summary
$sql = "SELECT 
            SUM(CASE WHEN type = 'income' THEN amount ELSE 0 END) AS income,
            SUM(CASE WHEN type = 'expense' THEN amount ELSE 0 END) AS expense
        FROM transactions";

$result = $conn->query($sql);
$summary = $result->fetch_assoc();

$summary['remaining'] = $summary['income'] - $summary['expense'];

echo json_encode(['status' => 'success', 'income' => $summary['income'], 'expense' => $summary['expense'], 'remaining' => $summary['remaining']]);

$conn->close();
?>
