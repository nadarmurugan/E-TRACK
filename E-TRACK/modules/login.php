<?php
include 'db.php';

// Retrieve POST data
$email = $_POST['email'];
$password = $_POST['password'];

// Validate input (basic check for empty fields)
if (empty($email) || empty($password)) {
    echo json_encode(['status' => 'error', 'message' => 'Email and password are required']);
    exit();
}

// Prepare SQL query to check if the user exists in the database
$sql = "SELECT * FROM users WHERE email = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param('s', $email);
$stmt->execute();
$result = $stmt->get_result();

// Check if a user with the provided email exists
if ($result->num_rows > 0) {
    $user = $result->fetch_assoc();

    // Compare the entered password with the one stored in the database (no hash comparison)
    if ($password === $user['password']) {
        // Start the session and store user data (optional)
        session_start();
        $_SESSION['user_id'] = $user['id'];  // Storing the user ID in the session
        $_SESSION['username'] = $user['username'];

        echo json_encode(['status' => 'success', 'message' => 'Login successful']);
    } else {
        echo json_encode(['status' => 'error', 'message' => 'Incorrect password']);
    }
} else {
    echo json_encode(['status' => 'error', 'message' => 'User not found']);
}

// Close the statement and database connection
$stmt->close();
$conn->close();
?>
