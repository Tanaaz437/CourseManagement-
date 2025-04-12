<?php
include '../database_connection/db_connection.php';

$teacher_id = isset($_GET['id']) ? intval($_GET['id']) : 0;

if ($teacher_id > 0) {
    // Prepare the SQL statement
    $sql = "DELETE FROM teachers WHERE id = ?";
    $stmt = $conn->prepare($sql);

    if ($stmt) {
        // Bind parameters and execute the statement
        $stmt->bind_param('i', $teacher_id);

        if ($stmt->execute()) {
            // Redirect to the teacher list page
            header('Location: teacher.php');
            exit();
        } else {
            echo "Error deleting teacher record: " . $stmt->error;
        }

        // Close the statement
        $stmt->close();
    } else {
        echo "Error preparing statement: " . $conn->error;
    }
} else {
    echo "Invalid Teacher ID.";
}

// Close the database connection
$conn->close();
?>
