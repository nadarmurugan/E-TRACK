<?php
include 'db.php'; // Contains DB connection

// Check if the form is submitted
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['add_user'])) {
    $username = $_POST['username'];
    $email = $_POST['email'];
    $phone_number = $_POST['phone_number'];
    $password = $_POST['password']; // No password hashing (as per request)

    // Validate phone number (10 digits)
    if (!preg_match("/^\d{10}$/", $phone_number)) {
        echo "<script>
                alert('Phone number must be 10 digits.');
                setTimeout(function() {
                    window.location.href = 'add.php';
                }, 1000);
              </script>";
        exit;
    }

    // Validate password (minimum 8 characters)
    if (strlen($password) < 8) {
        echo "<script>
                alert('Password must be at least 8 characters long.');
                setTimeout(function() {
                    window.location.href = 'add.php';
                }, 1000);
              </script>";
        exit;
    }

    // Prepare SQL to insert the new user
    $sql = "INSERT INTO users (username, email, phone_number, password) VALUES (?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ssss", $username, $email, $phone_number, $password);

    if ($stmt->execute()) {
        echo "<script>
                alert('User added successfully!');
                window.location.href = 'admin-dashboard.php';
              </script>";
    } else {
        echo "<script>
                alert('Error adding user.');
                setTimeout(function() {
                    window.location.href = 'add.php';
                }, 1000);
              </script>";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add User - Admin Dashboard</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600&display=swap" rel="stylesheet">
    <style>
        /* General Styling */
        body {
            font-family: 'Poppins', sans-serif;
            background-color: #f0f4f8;
            margin: 0;
            padding: 0;
        }

        .container {
            max-width: 600px;
            margin: 50px auto;
            background-color: #ffffff;
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0 6px 15px rgba(0, 0, 0, 0.1);
        }

        h1 {
            text-align: center;
            color: #333;
            font-size: 2.5rem;
            margin-bottom: 20px;
        }

        form {
            display: flex;
            flex-direction: column;
            gap: 20px;
        }

        label {
            font-size: 1rem;
            color: #555;
        }

        input[type="text"], input[type="email"], input[type="password"] {
            padding: 12px;
            border: 2px solid #ccc;
            border-radius: 8px;
            font-size: 1rem;
            width: 100%;
            box-sizing: border-box;
            outline: none;
            transition: border 0.3s;
        }

        input[type="text"]:focus, input[type="email"]:focus, input[type="password"]:focus {
            border-color: #4CAF50;
        }

        .eye-icon {
            position: absolute;
            right: 15px;
            top: 15px;
            cursor: pointer;
            font-size: 1.5rem;
            color: #555;
        }

        button.btn {
            padding: 12px;
            background-color: #4CAF50;
            border: none;
            color: white;
            border-radius: 8px;
            font-size: 1.1rem;
            cursor: pointer;
            transition: background-color 0.3s;
        }

        button.btn:hover {
            background-color: #45a049;
        }

        .back-btn {
            text-align: center;
            text-decoration: none;
            color: #4CAF50;
            font-size: 1rem;
            display: block;
            margin-top: 15px;
        }

        .back-btn:hover {
            color: #45a049;
        }
    </style>
</head>

<body>
    <div class="container">
        <h1>Add User</h1>

        <form method="POST" action="">

            <label for="username">Username:</label>
            <input type="text" id="username" name="username" required><br>

            <label for="email">Email:</label>
            <input type="email" id="email" name="email" required><br>

            <label for="phone_number">Phone Number:</label>
            <input type="text" id="phone_number" name="phone_number" required><br>

            <label for="password">Password:</label>
            <div style="position: relative;">
                <input type="password" id="password" name="password" required>
                <span id="toggle-password" class="eye-icon" onclick="togglePassword()">👁️</span>
            </div>

            <button type="submit" name="add_user" class="btn">Add User</button>

            <a href="admin-dashboard.php" class="back-btn">Back to Dashboard</a>
        </form>
    </div>

    <script>
        // Password toggle function
        function togglePassword() {
            var passwordField = document.getElementById('password');
            var toggleIcon = document.getElementById('toggle-password');
            if (passwordField.type === "password") {
                passwordField.type = "text";
                toggleIcon.textContent = "🙈"; // Change icon to "hide"
            } else {
                passwordField.type = "password";
                toggleIcon.textContent = "👁️"; // Change icon to "show"
            }
        }
    </script>
</body>
</html>
