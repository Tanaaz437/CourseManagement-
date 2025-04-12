<?php
include '../database_connection/db_connection.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $student_id = intval($_POST['student_id']);
    $course_id = intval($_POST['course_id']);

    if ($student_id > 0 && $course_id > 0) {
        // Check if the enrollment already exists
        $sql_check = "SELECT COUNT(*) AS count FROM student_courses WHERE student_id = ? AND course_id = ?";
        if ($stmt_check = $conn->prepare($sql_check)) {
            $stmt_check->bind_param('ii', $student_id, $course_id);
            $stmt_check->execute();
            $result_check = $stmt_check->get_result();
            $count = $result_check->fetch_assoc()['count'];

            if ($count == 0) {
                // Insert new enrollment
                $sql_insert = "INSERT INTO student_courses (student_id, course_id, enrollment_date) VALUES (?, ?, NOW())";
                if ($stmt_insert = $conn->prepare($sql_insert)) {
                    $stmt_insert->bind_param('ii', $student_id, $course_id);
                    $stmt_insert->execute();
                    echo "Course assigned successfully.";
                } else {
                    echo "Error: " . $conn->error;
                }
            } else {
                echo "This student is already enrolled in this course.";
            }

            $stmt_check->close();
        } else {
            echo "Error: " . $conn->error;
        }
    } else {
        echo "Invalid input.";
    }

    $conn->close();
}
?>
