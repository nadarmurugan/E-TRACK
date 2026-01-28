<?php
include 'db.php';

// Retrieve POST data
$username = $_POST['username'];
$email = $_POST['email'];
$phone_number = $_POST['phone_number'];
$password = $_POST['password'];
$confirm_password = $_POST['confirm_password'];

// Validate phone number (must be exactly 10 digits)
if (!preg_match('/^\d{10}$/', $phone_number)) {
    echo json_encode(['status' => 'error', 'message' => 'Phone number must be exactly 10 digits']);
    exit();
}

// Validate password length (minimum 8 characters)
if (strlen($password) < 8) {
    echo json_encode(['status' => 'error', 'message' => 'Password must be at least 8 characters long']);
    exit();
}

// Check if passwords match
if ($password !== $confirm_password) {
    echo json_encode(['status' => 'error', 'message' => 'Passwords do not match']);
    exit();
}

// Prepare and execute SQL query (without hashing the password)
$sql = "INSERT INTO users (username, email, phone_number, password) VALUES (?, ?, ?, ?)";
$stmt = $conn->prepare($sql);
$stmt->bind_param('ssss', $username, $email, $phone_number, $password);

if ($stmt->execute()) {
    echo json_encode(['status' => 'success', 'message' => 'Registration successful']);
} else {
    echo json_encode(['status' => 'error', 'message' => 'Registration failed']);
}

$stmt->close();
$conn->close();
?>
