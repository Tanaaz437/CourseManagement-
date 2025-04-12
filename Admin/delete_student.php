<?php
include '../database_connection/db_connection.php';

// Use 'id' instead of 'student_id'
$student_id = isset($_GET['id']) ? intval($_GET['id']) : 0;

if ($student_id > 0) {
    // Debugging output
    echo "Attempting to delete student with ID: $student_id <br>";

    $sql = "DELETE FROM student_admin WHERE id = ?";
    $stmt = $conn->prepare($sql);

    if ($stmt) {
        $stmt->bind_param('i', $student_id);

        if ($stmt->execute()) {
            if ($stmt->affected_rows > 0) {
                header('Location: student.php'); // Redirect after successful deletion
                exit();
            } else {
                echo "No records deleted. Student ID might not exist.";
            }
        } else {
            echo "Error executing statement: " . $stmt->error; // Show actual error
        }

        $stmt->close();
    } else {
        echo "Error preparing statement: " . $conn->error; // Show preparation error
    }
} else {
    echo "Invalid student ID: $student_id"; // Display the ID being processed
}

$conn->close();
?>
