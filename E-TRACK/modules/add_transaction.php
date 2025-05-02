<?php
// Database connection
$conn = new mysqli('localhost', 'root', '', 'E-TRACK');

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$description = $conn->real_escape_string($_POST['description']);
$amount = $conn->real_escape_string($_POST['amount']);
$type = $conn->real_escape_string($_POST['type']);

// Insert transaction
$sql = "INSERT INTO transactions (description, amount, type) VALUES ('$description', '$amount', '$type')";
if ($conn->query($sql) === TRUE) {
    $transaction_id = $conn->insert_id;
    echo json_encode(['status' => 'success', 'transaction' => ['id' => $transaction_id, 'description' => $description, 'amount' => $amount, 'type' => $type]]);
} else {
    echo json_encode(['status' => 'error']);
}

$conn->close();
?>
