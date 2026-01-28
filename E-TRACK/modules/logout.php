<?php
session_start();

// Check if the user is logged in
if (!isset($_SESSION['username'])) {
    header("Location: login.php"); // Redirect to login page if not logged in
    exit();
}

// Handle logout action
if (isset($_GET['confirm']) && $_GET['confirm'] == 'yes') {
    // Destroy the session to log the user out
    session_unset();
    session_destroy();
    
    // Redirect to the login page after successful logout
    header("Location: login.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Logout Confirmation</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f9f9f9;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
        }
        .confirmation-box {
            background-color: white;
            padding: 30px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            text-align: center;
        }
        h2 {
            color: #333;
        }
        .button-group {
            margin-top: 20px;
        }
        .button-group button {
            padding: 10px 20px;
            border-radius: 5px;
            border: none;
            margin: 5px;
            cursor: pointer;
        }
        .yes-btn {
            background-color: #4CAF50;
            color: white;
        }
        .no-btn {
            background-color: #f44336;
            color: white;
        }
        .yes-btn:hover {
            background-color: #45a049;
        }
        .no-btn:hover {
            background-color: #e53935;
        }
    </style>
</head>
<body>

<div class="confirmation-box">
    <h2>Are you sure you want to log out?</h2>
    <div class="button-group">
        <a href="logout.php?confirm=yes">
            <button class="yes-btn">Yes, Logout</button>
        </a>
        <a href="index.php">
            <button class="no-btn">No, Stay Logged In</button>
        </a>
    </div>
</div>

</body>
</html>
