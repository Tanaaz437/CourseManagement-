<?php
     include '../database_connection/db_connection.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Collect form data
    $allocation = $_POST['student_allocation']; // student_allocation
    $select_teacher = $_POST['select_teacher']; // select_teacher

    // Prepare an insert statement
    $sql = "INSERT INTO teacher_allocate (student_allocation, select_teacher) VALUES (?, ?)";

    // Prepare and bind parameters to avoid SQL injection
    if ($stmt = $conn->prepare($sql)) {
        $stmt->bind_param("is", $allocation, $select_teacher); // "ss" means two strings will be bound
        
        // Execute the statement
        if ($stmt->execute()) {
            // Redirect to course.php after successful insertion
            header("Location: course.php");
            exit(); // Terminate the script after the redirection
        } else {
            echo "Error: Could not execute query: " . $stmt->error;
        }

        // Close the statement
        $stmt->close();
    } else {
        echo "Error: Could not prepare query: " . $conn->error;
    }
}

// Close the database connection
$conn->close();
?>