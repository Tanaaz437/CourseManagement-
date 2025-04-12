<?php
     include '../database_connection/db_connection.php';


$course_id = isset($_GET['id']) ? intval($_GET['id']) : 0;

if ($course_id > 0) {
    // Prepare the SQL statement for deletion
    $sql = "DELETE FROM courses2 WHERE id = ?";
    $stmt = $conn->prepare($sql);

    if ($stmt) {
        // Bind the course ID parameter to the statement
        $stmt->bind_param('i', $course_id);

        if ($stmt->execute()) {
            
            header('Location: course.php?msg=Course deleted successfully');
            exit();
        } else {
          
            echo "Error deleting course record: " . $stmt->error;
        }

     
        $stmt->close();
    } else {
       
        echo "Error preparing statement: " . $conn->error;
    }
} else {
   
    echo "Invalid Course ID.";
}


$conn->close();
?>