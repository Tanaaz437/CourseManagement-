<?php
include '../database_connection/db_connection.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $id = $_POST['id'];
    $name = $_POST['name'];

    // Update the group in the database
    $stmt = $conn->prepare("UPDATE groupslots SET name = ? WHERE id = ?");
    $stmt->bind_param("si", $name, $id);

    if ($stmt->execute()) {
        // Redirect back to the group list after successful update
        header('Location: group.php');
    } else {
        echo 'Error updating group: ' . $conn->error;
    }

    $stmt->close();
}

$conn->close();
?>
