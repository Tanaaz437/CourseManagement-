<?php
// Include the database connection file
include '../database_connection/db_connection.php';

// Capture form data
$name = $_POST['name'];

// Prepare and bind
$stmt = $conn->prepare("INSERT INTO groupslots(name) VALUES (?)");
$stmt->bind_param("s", $name);

// Execute the statement and handle errors
if ($stmt->execute()) {
    header('Location: group.php');
    exit();
} else {
    echo "Error: " . $stmt->error;
}

// Close the statement and connection
$stmt->close();
$conn->close();
?>
