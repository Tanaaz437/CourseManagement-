<?php
// Include the database connection file
include '../database_connection/db_connection.php';

// Number of records per page
$recordsPerPage = 10; 

// Get the current page number from the URL, if not present default to 1
$page = isset($_GET['page']) ? $_GET['page'] : 1;

// Calculate the offset for the SQL query
$offset = ($page - 1) * $recordsPerPage;

// Fetch all courses from the courses2 table
$queryCourses = "SELECT * FROM courses2";
$resultCourses = mysqli_query($conn, $queryCourses);

if (mysqli_num_rows($resultCourses) > 0) {
    // Display the list of courses
    while ($course = mysqli_fetch_assoc($resultCourses)) {
        echo "<h2>Students Enrolled for: " . $course['title'] . "</h2>";

        // Get the course ID
        $courseId = $course['id'];

        // Fetch students enrolled in the current course with pagination
        $queryStudents = "
            SELECT sa.firstname, sa.lastname, sa.id AS student_id, sa.email, sc.status, sc.certificate_approved, c.title AS course_title
            FROM stud_cour sc
            INNER JOIN student_admin sa ON sc.student_id = sa.id
            INNER JOIN courses2 c ON sc.course_id = c.id
            WHERE sc.course_id = $courseId
            LIMIT $offset, $recordsPerPage
        ";

        $resultStudents = mysqli_query($conn, $queryStudents);

        if (mysqli_num_rows($resultStudents) > 0) {
            echo "<table border='1'>
                    <tr>
                        <th>Student Name</th>
                        <th>Student ID</th>
                        <th>Email</th>
                        <th>Status</th>
                        <th>Certificate Approved</th>
                        <th>Action</th>
                    </tr>";

            // Display student details for each enrolled student in the course
            while ($student = mysqli_fetch_assoc($resultStudents)) {
                echo "<tr>
                        <td>" . $student['firstname'] . " " . $student['lastname'] . "</td>
                        <td>" . $student['student_id'] . "</td>
                        <td>" . $student['email'] . "</td>
                        <td>" . ($student['status'] ? $student['status'] : 'Not Set') . "</td>
                        <td>" . ($student['certificate_approved'] ? $student['certificate_approved'] : 'No') . "</td>
                        <td>
                            <form method='post'>
                                <input type='hidden' name='student_id' value='" . $student['student_id'] . "' />
                                <input type='hidden' name='course_id' value='" . $courseId . "' />
                                <input  type='submit' name='status_update' value='Ongoing' class='ongoing' />
                                <input type='submit' name='status_update' value='Approved' class='approved' />
                            </form>
                        </td>
                    </tr>";
            }
            echo "</table>";
        } else {
            echo "No students enrolled for this course.";
        }

        // Count total number of students in this course to calculate total pages
        $queryCountStudents = "
            SELECT COUNT(*) AS total_students
            FROM stud_cour sc
            WHERE sc.course_id = $courseId
        ";
        $resultCount = mysqli_query($conn, $queryCountStudents);
        $countData = mysqli_fetch_assoc($resultCount);
        $totalStudents = $countData['total_students'];
        $totalPages = ceil($totalStudents / $recordsPerPage); // Calculate total pages

        // Display pagination links
        echo "<div class='pagination'>";
        for ($i = 1; $i <= $totalPages; $i++) {
            echo "<a href='?page=$i'>$i</a> ";
        }
        echo "</div>";
    }
} else {
    echo "No courses available.";
}

// Handle the form submission to update student status
if (isset($_POST['status_update'])) {
    $studentId = $_POST['student_id'];
    $courseId = $_POST['course_id'];
    $newStatus = $_POST['status_update']; // "Ongoing" or "Approved"

    $certificateApproved=($newStatus==='Approved')? 'Yes':'No';

    // Update the status based on the selected button
    $queryUpdateStatus = "
        UPDATE stud_cour
        SET status = '$newStatus',certificate_approved='$certificateApproved'
        WHERE student_id = $studentId AND course_id = $courseId
    ";

    if (mysqli_query($conn, $queryUpdateStatus)) {
        echo "Status updated to '$newStatus' for student ID: $studentId. Certificate Approved: '$certificateApproved'.";
    } else {
        echo "Failed to update status: " . mysqli_error($conn);
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="course.css">
</head>
<body class="mybody">
    <button id="Previous" onclick="Back()">Back</button>  
<script src="/Javascript/script.js"></script>
</body>
</html>
