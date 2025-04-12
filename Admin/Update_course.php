<?php
include '../database_connection/db_connection.php';

// Get data from POST request
$course_id = isset($_POST['id']) ? intval($_POST['id']) : 0;
$code = isset($_POST['code']) ? $_POST['code'] : '';
$title = isset($_POST['title']) ? $_POST['title'] : '';
$faculty = isset($_POST['faculty']) ? $_POST['faculty'] : '';
/* $visible = isset($_POST['visible']) ? $_POST['visible'] : []; // Array of selected checkboxes
 */$group = isset($_POST['group']) ? $_POST['group'] : '';
$summary = isset($_POST['summary']) ? $_POST['summary'] : '';
$studentlimit = isset($_POST['studentlimit']) ? intval($_POST['studentlimit']) : 0;

if ($course_id > 0) {
    // Handle multi-checkbox 'visible_faculty'
/*     $visible_faculty_str = implode(', ', $visible); // Convert array to comma-separated string
 */
    // Prepare SQL statement to update the course details
    $sql = "UPDATE courses2 SET code = ?, title = ?, faculty = ?, `group` = ?, summary = ?, studentlimit = ? WHERE id = ?";

    // Check if the SQL statement is prepared correctly
    if ($stmt = $conn->prepare($sql)) {

        // Bind the parameters
        // Use correct data types: 's' for strings, 'i' for integers
        $stmt->bind_param('issssii', $code, $title, $faculty,  $group, $summary, $studentlimit, $course_id);

        // Execute the statement
        if ($stmt->execute()) {
            // Redirect to 'course.php' after successful update
            header('Location: course.php');
            exit(); // Make sure to stop script execution after redirect
        } else {
            // Output execution error
            echo "Error updating course details: " . $stmt->error;
        }

        // Close the statement
        $stmt->close();
    } else {
        // Output preparation error
        echo "Error preparing SQL statement: " . $conn->error;
    }
} else {
    echo "Invalid course ID.";
}

// Close the connection
$conn->close();
?>
