<?php
include 'db.php'; // Contains DB connection

// Check if edit_id is passed via GET
if (isset($_GET['edit_id'])) {
    $edit_id = $_GET['edit_id'];

    // Fetch the current user data
    $sql = "SELECT * FROM users WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $edit_id);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $user = $result->fetch_assoc();
    } else {
        echo "User not found.";
        exit;
    }
} else {
    echo "No user ID specified.";
    exit;
}

// Update user data when form is submitted
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['update_user'])) {
    $username = $_POST['username'];
    $email = $_POST['email'];
    $phone_number = $_POST['phone_number'];
    $password = $_POST['password']; // Handle password securely (hashing, etc.)

    // Validate phone number (10 digits)
    if (!preg_match("/^\d{10}$/", $phone_number)) {
        echo "<script>
                alert('Phone number must be 10 digits.');
                setTimeout(function() {
                    window.location.href = 'edit_user.php?edit_id=".$edit_id."';
                }, 3000); // Redirect after 3 seconds
              </script>";
        exit;
    }

    // Validate password (minimum 8 characters)
    if (strlen($password) < 8) {
        echo "<script>
                alert('Password must be at least 8 characters long.');
                setTimeout(function() {
                    window.location.href = 'edit_user.php?edit_id=".$edit_id."';
                }, 3000); // Redirect after 3 seconds
              </script>";
        exit;
    }

    // Prepare SQL to update the user record
    $sql = "UPDATE users SET username = ?, email = ?, phone_number = ?, password = ? WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ssssi", $username, $email, $phone_number, $password, $edit_id);

    if ($stmt->execute()) {
        echo "<script>
                alert('User updated successfully!');
                window.location.href = 'admin-dashboard.php';
              </script>";
    } else {
        echo "<script>
                alert('Error updating user.');
                setTimeout(function() {
                    window.location.href = 'edit_user.php?edit_id=".$edit_id."';
                }, 1000); // Redirect after 3 seconds
              </script>";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit User - Admin Dashboard</title>
    <link rel="stylesheet" href="style.css"> <!-- Linking the CSS file -->
</head>
<style>
    /* General Styling */
body {
    font-family: Arial, sans-serif;
    background-color: #f4f7fc;
    margin: 0;
    padding: 0;
}

.container {
    max-width: 600px;
    margin: 50px auto;
    background-color: #fff;
    padding: 20px;
    border-radius: 8px;
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
}

h1 {
    text-align: center;
    color: #333;
    font-size: 2rem;
}

/* Form styling */
form {
    display: flex;
    flex-direction: column;
    gap: 15px;
}

input[type="text"], input[type="email"], input[type="password"] {
    padding: 10px;
    border: 1px solid #ccc;
    border-radius: 5px;
    font-size: 1rem;
    width: 100%;
}

button.btn {
    padding: 10px 15px;
    background-color: #4CAF50;
    border: none;
    color: white;
    border-radius: 5px;
    font-size: 1rem;
    cursor: pointer;
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
    margin-top: 10px;
}

.back-btn:hover {
    color: #45a049;
}

/* Password Toggle */
.password-container {
    position: relative;
}

.eye-icon {
    position: absolute;
    right: 10px;
    top: 35px;
    cursor: pointer;
    font-size: 1.5rem;
    color: #333;
}

/* Validation Feedback */
input:invalid {
    border: 2px solid red;
}
</style>

<body>
    <div class="container">
        <h1>Edit User</h1>

        <form method="POST" action="">

            <input type="hidden" name="edit_id" value="<?php echo $user['id']; ?>">

            <label for="username">Username:</label><br>
            <input type="text" id="username" name="username" value="<?php echo $user['username']; ?>" required><br><br>

            <label for="email">Email:</label><br>
            <input type="email" id="email" name="email" value="<?php echo $user['email']; ?>" required><br><br>

            <label for="phone_number">Phone Number:</label><br>
            <input type="text" id="phone_number" name="phone_number" value="<?php echo $user['phone_number']; ?>" required><br><br>

            <label for="password">Password:</label><br>
            <div class="password-container">
                <input type="password" id="password" name="password" value="<?php echo $user['password']; ?>" required><br>
                <span id="toggle-password" class="eye-icon" onclick="togglePassword()">👁️</span>
            </div><br><br>

            <button type="submit" name="update_user" class="btn">Update User</button>

            <br><br>
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
