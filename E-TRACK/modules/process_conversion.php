<?php
$servername = "localhost";
$username = "root"; // Change as needed
$password = ""; // Change as needed
$dbname = "E-TRACK";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $amount = $_POST['amount'];
    $fromCurrency = $_POST['fromCurrency'];
    $toCurrency = $_POST['toCurrency'];
    $convertedAmount = $_POST['convertedAmount'];
    $description = $_POST['description'];

    // Insert data into the table
    $stmt = $conn->prepare("INSERT INTO conversions (amount, from_currency, to_currency, converted_amount, description) VALUES (?, ?, ?, ?, ?)");
    $stmt->bind_param("sssss", $amount, $fromCurrency, $toCurrency, $convertedAmount, $description);

    if ($stmt->execute()) {
        echo "Data stored successfully.";
    } else {
        echo "Error: " . $stmt->error;
    }

    $stmt->close();
}

// Retrieve latest conversion records
$sql = "SELECT * FROM conversions ORDER BY timestamp DESC LIMIT 5";
$result = $conn->query($sql);

$conversionRecords = [];
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $conversionRecords[] = $row;
    }
}

$conn->close();

?>

<!-- Displaying the converted amounts -->
<div class="conversion-records">
    <h3>Recent Conversions</h3>
    <ul>
        <?php foreach ($conversionRecords as $record): ?>
            <li>
                Amount: <?= htmlspecialchars($record['amount']) ?> <?= htmlspecialchars($record['from_currency']) ?> to <?= htmlspecialchars($record['converted_amount']) ?> <?= htmlspecialchars($record['to_currency']) ?> - <?= htmlspecialchars($record['description']) ?> (<?= $record['timestamp'] ?>)
            </li>
        <?php endforeach; ?>
    </ul>
</div>
