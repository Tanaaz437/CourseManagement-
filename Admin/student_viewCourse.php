<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Student View Course</title>
    <link rel="stylesheet" href="student.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css" integrity="sha512-Kc323vGBEqzTmouAECnVceyQqyqdsSiqLQISBL29aUW4U/M7pSPA/gEUZQqv1cwx4OnYxTxve5UMg5GT6L4JJg==" crossorigin="anonymous" referrerpolicy="no-referrer" />
</head>
<body>
    <div class="navbar">
        <div id="aisc"> AISC </div>
        <div id="nav-icon"> 
            <button class="user-button"> 
                <i class="fa-solid fa-circle-user"></i>
            </button>
        </div>
    </div>

    <div class="sidebar">
        <ul class="menu">
            <li class="home">
                <a id="home-icon" href="/Admin/home.php"><i class="fa-solid fa-house"></i> Home </a>
                <div class="menu-divider"></div>
            </li>
            <li class="teacher">
                <a id="teacher-icon" href="/Admin/teacher.php"> <i class="fa-solid fa-users"></i> Teacher</a> 
                <div class="menu-divider"></div>
            </li>
            <li class="student">
                <a id="student-icon" href="/Admin/student.php"> <i class="fa-solid fa-users"></i> Student</a> 
                <div class="menu-divider"></div>
            </li>
            <li class="group">
                <a id="group-icon" href="/Admin/group.php"> <i class="fa-sharp-duotone fa-solid fa-list"></i> Group</a> 
                <div class="menu-divider"></div>
            </li>
            <li class="course">
                <a id="course-icon" href="/Admin/course.php"> <i class="fa-sharp-duotone fa-solid fa-list"></i> Course </a> 
                <div class="menu-divider"></div>
            </li>
            <li class="email-temp">
                <a id="email-icon" href="/Admin/emailTemplate.php"> <i class="fa-sharp-duotone fa-solid fa-list"></i> Email Template</a> 
                <div class="menu-divider"></div>
            </li>
        </ul>
    </div>

    <div id="main-content">
        <div class="breadcrumb">
            <ul>
                <li>
                <i class="fa-solid fa-bars"></i>
                    Student Course Details
                </li>
            </ul>
        </div>

        <div class="s1-button">
            <button id="back" onclick="window.location.href='student.php';">
                <i class="fa-solid fa-arrow-left"></i> Back
            </button>
        </div>

        <?php
        include '../database_connection/db_connection.php';

        // Get student_id from query string
        $student_id = isset($_GET['student_id']) ? intval($_GET['student_id']) : 0;

        if ($student_id > 0) {
            // Fetch student details
            $sql_student = "SELECT * FROM student_admin WHERE id = ?";
            if ($stmt_student = $conn->prepare($sql_student)) {
                $stmt_student->bind_param('i', $student_id);
                $stmt_student->execute();
                $result_student = $stmt_student->get_result();
                $student = $result_student->fetch_assoc();

                if ($student) {
                    echo "<h2>Student Details</h2>";
                    echo "<p><strong>ID:</strong> " . htmlspecialchars($student['id']) . "</p>";
                    echo "<p><strong>MID:</strong> " . htmlspecialchars($student['mid']) . "</p>";
                    echo "<p><strong>Name:</strong> " . htmlspecialchars($student['firstname'] . ' ' . $student['lastname']) . "</p>";
                    echo "<p><strong>Email:</strong> " . htmlspecialchars($student['email']) . "</p>";
                    echo "<p><strong>Mobile Number:</strong> " . htmlspecialchars($student['mobile_number']) . "</p>";
                    echo "<p><strong>Class:</strong> " . htmlspecialchars($student['select_class']) . "</p>";
                    echo "<p><strong>Faculty:</strong> " . htmlspecialchars($student['select_faculty']) . "</p>";

                    // Fetch courses enrolled by the student
                    $sql_courses = "
                        SELECT c.title, sc.enrollment_date
                        FROM student_courses sc
                        JOIN courses c ON sc.course_id = c.id
                        WHERE sc.student_id = ?";
                    if ($stmt_courses = $conn->prepare($sql_courses)) {
                        $stmt_courses->bind_param('i', $student_id);
                        $stmt_courses->execute();
                        $result_courses = $stmt_courses->get_result();

                        echo "<h3>Enrolled Courses</h3>";
                        if ($result_courses->num_rows > 0) {
                            echo "<table border='1'>";
                            echo "<thead>
                                    <tr>
                                        <th>Course Name</th>
                                        <th>Enrollment Date</th>
                                    </tr>
                                  </thead>";
                            echo "<tbody>";
                            while ($course = $result_courses->fetch_assoc()) {
                                echo "<tr>";
                                echo "<td>" . htmlspecialchars($course['title']) . "</td>";
                                echo "<td>" . htmlspecialchars($course['enrollment_date']) . "</td>";
                                echo "</tr>";
                            }
                            echo "</tbody>";
                            echo "</table>";
                        } else {
                            echo "<p>No courses found for this student.</p>";
                        }

                        $stmt_courses->close();
                    } else {
                        echo "<p>Error preparing courses query: " . $conn->error . "</p>";
                    }

                    $stmt_student->close();
                } else {
                    echo "<p>Student not found.</p>";
                }
            } else {
                echo "<p>Error preparing student query: " . $conn->error . "</p>";
            }
        } else {
            echo "<p>Invalid student ID.</p>";
        }

        $conn->close();
        ?>
    </div>

    <script src="/Javascript/script.js"></script>
</body>
</html>
