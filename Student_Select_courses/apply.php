<?php
include '../database_connection/db_connection.php';

if (isset($_POST['course_id']) && isset($_POST['student_id'])) {
    $course_id = $_POST['course_id'];
    $student_id = $_POST['student_id'];

    // Check if the course exists
    $checkCourse = $conn->prepare("SELECT id FROM courses2 WHERE id = ?");
    $checkCourse->bind_param("i", $course_id);
    $checkCourse->execute();
    $courseResult = $checkCourse->get_result();

    if ($courseResult->num_rows == 0) {
        echo "Error: The course does not exist.";
    } else {
        // Check if the student has already applied for this course
        $checkDuplicate = $conn->prepare("SELECT * FROM course_applications WHERE student_id = ? AND course_id = ?");
        $checkDuplicate->bind_param("ii", $student_id, $course_id);
        $checkDuplicate->execute();
        $result = $checkDuplicate->get_result();

        if ($result->num_rows > 0) {
            echo "You have already applied for this course.";
        } else {
            // Check if the student has already applied for 2 courses
            $checkLimit = $conn->prepare("SELECT COUNT(*) AS application_count FROM course_applications WHERE student_id = ?");
            $checkLimit->bind_param("i", $student_id);
            $checkLimit->execute();
            $limitResult = $checkLimit->get_result();
            $limitRow = $limitResult->fetch_assoc();

            if ($limitRow['application_count'] >= 2) {
                echo "You cannot apply for more than 2 courses.";
            } else {
                // Proceed to insert the new application
                $stmt = $conn->prepare("INSERT INTO course_applications (student_id, course_id) VALUES (?, ?)");
                $stmt->bind_param("ii", $student_id, $course_id);

                if ($stmt->execute()) {
                    // After the application is successful, insert into stud_cour as well
                    $insertStudCour = $conn->prepare("INSERT INTO stud_cour (student_id, course_id, status, certificate_approved) VALUES (?, ?, 'Ongoing', 'No')");
                    $insertStudCour->bind_param("ii", $student_id, $course_id);

                    if ($insertStudCour->execute()) {
                        // Fetch course name from courses2 table
                        $courseQuery = $conn->prepare("SELECT title FROM courses2 WHERE id = ?");
                        $courseQuery->bind_param("i", $course_id);
                        $courseQuery->execute();
                        $courseResult = $courseQuery->get_result();
                        $courseRow = $courseResult->fetch_assoc();
                        $courseName = $courseRow['title'];

                        // Respond with success message including the course name
                        echo "Application successful! You have been enrolled in the course: " . htmlspecialchars($courseName);
                    } else {
                        echo "Error enrolling student: " . $insertStudCour->error;
                    }
                    $insertStudCour->close();
                } else {
                    echo "Error applying for course: " . $stmt->error;
                }
                $stmt->close();
            }
            $checkLimit->close();
        }
        $checkDuplicate->close();
    }
    $checkCourse->close();
    $conn->close();
} else {
    echo "Invalid data.";
}
?>
