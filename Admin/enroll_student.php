<?php
include '../database/db_connection.php';
session_start();

// Ensure student is logged in
if (!isset($_SESSION['student_id'])) {
    echo "Please log in to enroll.";
    exit;
}

if (isset($_POST['student_id']) && isset($_POST['course_id'])) {
    $studentId = $_POST['student_id'];
    $courseId = $_POST['course_id'];

    // Check if the student is already enrolled in this course
    $queryCheck = "SELECT * FROM stud_cour WHERE student_id = $studentId AND course_id = $courseId";
    $resultCheck = mysqli_query($conn, $queryCheck);

    if (mysqli_num_rows($resultCheck) == 0) {
        // Student is not enrolled, so insert the new enrollment
        $queryInsert = "
            INSERT INTO stud_cour (student_id, course_id, status, certificate_approved)
            VALUES ($studentId, $courseId, 'Ongoing', 'No')
        ";

        if (mysqli_query($conn, $queryInsert)) {
            echo "Student successfully enrolled in the course!";
        } else {
            echo "Error enrolling student: " . mysqli_error($conn);
        }
    } else {
        echo "Student is already enrolled in this course.";
    }
} else {
    echo "Invalid request. Missing student_id or course_id.";
}
?>
