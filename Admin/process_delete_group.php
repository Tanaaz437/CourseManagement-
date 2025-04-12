<?php
include '../database_connection/db_connection.php';

$id = $_GET['id'];

$stmt = $conn->prepare("DELETE FROM groupslots WHERE id = ?");
$stmt->bind_param("i", $id);

if ($stmt->execute()) {
    header('Location: group.php');
    exit();
} else {
    echo "Error: " . $stmt->error;
}

$stmt->close();
$conn->close();
?>
