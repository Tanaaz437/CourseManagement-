<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Enroll in a Course</title>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
</head>
<body>
    <h1>Select a Course to Enroll</h1>

    <label for="course_id">Available Courses:</label>
    <select id="course_id">
        <option value="">--Select a Course--</option>
        <?php
        // Fetching courses dynamically from the database
        include '../database/db_connection.php';
        $queryCourses = "SELECT * FROM courses2";
        $resultCourses = mysqli_query($conn, $queryCourses);
        while ($course = mysqli_fetch_assoc($resultCourses)) {
            echo '<option value="' . $course['id'] . '">' . $course['title'] . '</option>';
        }
        ?>
    </select>

    <script>
        $(document).ready(function () {
            // Get student ID from session (embedded PHP)
            const studentId = <?php echo $_SESSION['student_id']; ?>;

            // Trigger the AJAX request when a course is selected
            $('#course_id').on('change', function() {
                const courseId = $(this).val();
                if (courseId) {
                    // Send AJAX request to enroll the student in the selected course
                    $.ajax({
                        url: 'enroll_student.php', // PHP file to handle enrollment
                        method: 'POST',
                        data: {
                            student_id: studentId,
                            course_id: courseId
                        },
                        success: function(response) {
                            alert(response);  // Show success or error message
                        },
                        error: function() {
                            alert('Error enrolling in the course.');
                        }
                    });
                }
            });
        });
    </script>
</body>
</html>
