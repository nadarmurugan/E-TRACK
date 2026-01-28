<?php
// Database connection
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "E-TRACk";

$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Get POST data
$username = $_POST['username'];
$email = $_POST['email'];
$password = $_POST['password']; // Plain text password
$gender = $_POST['gender'];
$contact = $_POST['contact'];
$address = $_POST['address'];
$occupation = $_POST['occupation'];
$age = $_POST['age'];
$dob = $_POST['dob'];

// Validate mobile number (must be exactly 10 digits)
if (!preg_match('/^\d{10}$/', $contact)) {
    echo json_encode(['error' => 'Invalid mobile number. It must be exactly 10 digits.']);
    exit();
}

// Prepare and bind
$stmt = $conn->prepare("INSERT INTO profile (username, email, password, gender, contact, address, occupation, age, dob) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)");
$stmt->bind_param("sssssssss", $username, $email, $password, $gender, $contact, $address, $occupation, $age, $dob);

if ($stmt->execute()) {
    // Fetch the last inserted ID
    $last_id = $stmt->insert_id;

    // Fetch the data for the inserted ID
    $result = $conn->query("SELECT * FROM profile WHERE id = $last_id");
    $data = $result->fetch_assoc();

    // Return the data as JSON
    echo json_encode($data);
} else {
    echo json_encode(['error' => $stmt->error]);
}

$stmt->close();
$conn->close();
?>
