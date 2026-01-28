<?php
include 'db.php'; // Contains DB connection

// Function to delete a record by ID
function deleteRecord($conn, $table, $id) {
    $sql = "DELETE FROM $table WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $id);
    return $stmt->execute();
}

// Function to fetch and display table records
function fetchTable($conn, $query, $columns, $tableTitle, $tableName) {
    $result = $conn->query($query);

    if ($result->num_rows > 0) {
        echo "<h2>$tableTitle</h2>";
        echo "<table border='1' cellpadding='10' cellspacing='0'>";

        // Print table headers
        echo "<tr>";
        foreach ($columns as $label) {
            echo "<th>$label</th>";
        }
        echo "<th>Action</th>";  // Add an action column for the edit and delete buttons
        echo "</tr>";

        // Print table rows
        while ($row = $result->fetch_assoc()) {
            echo "<tr>";
            foreach ($columns as $column => $label) {
                echo "<td>" . $row[$column] . "</td>";
            }

            // Add edit and delete buttons
            echo "<td>";
            if ($tableName == 'users') {
                echo "<form method='GET' action='edit_user.php' style='display:inline; margin-right: 10px;'>
                        <input type='hidden' name='edit_id' value='" . $row['id'] . "'>
                        <button type='submit' class='edit-btn' onclick='return confirm(\"Are you sure you want to edit this record?\");'>Edit</button>
                    </form>";
            }
            echo "<form method='POST' action='' style='display:inline;'>
                    <input type='hidden' name='delete_id' value='" . $row['id'] . "'>
                    <button type='submit' name='delete_$tableName' class='delete-btn' onclick='return confirm(\"Are you sure you want to delete this record?\");'>Delete</button>
                </form>";
            echo "</td>";
            echo "</tr>";
        }

        echo "</table><br><br>";
    } else {
        echo "<p>No records found in $tableTitle.</p><br>";
    }
}

// Check if delete request is made
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // List of tables to check for delete actions
    foreach (['users', 'transactions', 'profile', 'feedback', 'conversions'] as $table) {
        if (isset($_POST["delete_$table"])) {
            $id = $_POST['delete_id'];
            if (deleteRecord($conn, $table, $id)) {
                echo "<p>Record deleted successfully from $table.</p>";
            } else {
                echo "<p>Failed to delete record from $table.</p>";
            }
        }
    }
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard - E-TRACK</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background: #f9f9f9;
            margin: 20px;
        }
        h1 {
            background: linear-gradient(to right, #4e54c8, #8f94fb);
            color: white;
            padding: 20px;
            border-radius: 10px;
        }
        h2 {
            margin-top: 50px;
            color: #333;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 10px;
            background-color: #fff;
            box-shadow: 0 0 10px rgba(0,0,0,0.05);
        }
        th, td {
            padding: 10px;
            text-align: left;
        }
        th {
            background-color: #efefef;
        }
        tr:nth-child(even) {
            background-color: #f3f3f3;
        }
        button {
            padding: 8px 16px;
            border-radius: 5px;
            cursor: pointer;
        }
        .edit-btn {
            background-color: #4CAF50;
            color: white;
            border: none;
        }
        .edit-btn:hover {
            background-color: #45a049;
        }
        .delete-btn {
            background-color: #f44336;
            color: white;
            border: none;
        }
        .delete-btn:hover {
            background-color: #e53935;
        }
        .action-btns {
            display: flex;
            justify-content: space-between;
            margin-top: 20px;
        }
        /* Logout Button Styles */
.logout-btn {
    background-color: #e74c3c;  /* Red background color */
    color: white;               /* White text color */
    font-size: 16px;            /* Font size */
    padding: 10px 20px;         /* Padding around the text */
    border: none;               /* Remove border */
    border-radius: 5px;         /* Rounded corners */
    cursor: pointer;           /* Change cursor to pointer */
    transition: background-color 0.3s ease; /* Smooth transition for background color */
}

/* Hover effect for the logout button */
.logout-btn:hover {
    background-color: #c0392b;  /* Darker red when hovered */
}

    </style>
</head>
<body>

<button onclick="confirmLogout()">Logout</button>
    <h1>Admin Dashboard - E-TRACK</h1>

    <!-- USERS Table -->
    <?php
    fetchTable(
        $conn,
        "SELECT * FROM users",
        [
            "id" => "ID",
            "username" => "Username",
            "email" => "Email",
            "phone_number" => "Phone Number",
            "password" => "Password"
        ],
        "Users Table",
        "users"
    );
    ?>

    <!-- Add User Button -->
    <h2>Add New User</h2>
    <form method="GET" action="add.php">
        <button type="submit">Add User</button>
    </form>

    <!-- TRANSACTIONS Table -->
    <?php
    fetchTable(
        $conn,
        "SELECT * FROM transactions",
        [
            "id" => "ID",
            "description" => "Description",
            "amount" => "Amount",
            "type" => "Type"
        ],
        "Transactions Table",
        "transactions"
    );
    ?>

    <!-- PROFILE Table -->
    <?php
    fetchTable(
        $conn,
        "SELECT * FROM profile",
        [
            "id" => "ID",
            "username" => "Username",
            "email" => "Email",
            "password" => "Password",
            "gender" => "Gender",
            "contact" => "Contact",
            "address" => "Address",
            "occupation" => "Occupation",
            "age" => "Age",
            "dob" => "DOB"
        ],
        "Profile Table",
        "profile"
    );
    ?>

    <!-- FEEDBACK Table -->
    <?php
    fetchTable(
        $conn,
        "SELECT * FROM feedback",
        [
            "id" => "ID",
            "name" => "Name",
            "email" => "Email",
            "feedback" => "Feedback",
            "timestamp" => "Timestamp"
        ],
        "Feedback Table",
        "feedback"
    );
    ?>

    <!-- CONVERSIONS Table -->
    <?php
    fetchTable(
        $conn,
        "SELECT * FROM conversions",
        [
            "id" => "ID",
            "amount" => "Amount",
            "from_currency" => "From Currency",
            "to_currency" => "To Currency",
            "converted_amount" => "Converted Amount",
            "description" => "Description",
            "timestamp" => "Timestamp"
        ],
        "Conversions Table",
        "conversions"
    );

    $conn->close();
    ?>

</body>
<script>
    function confirmLogout() {
    // Show a confirmation dialog
    var confirmAction = confirm("Do you really want to log out from the admin dashboard?");
    
    // If user confirms, proceed with logout by submitting the form
    if (confirmAction) {
        window.location.href = 'logout.php';  // Redirect to the logout PHP script
    }
}
</script>
</html>
