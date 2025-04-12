<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>My Learning</title>
    
    <link rel="stylesheet" href="my_learning.css"> <!-- Include your CSS file for styling -->
</head>
<body>
<div class="navbar">
        <div id="aisc">AISC</div>
        <a href="/Student_Select_courses/Select_courses.php" id="course-link">
        <div id="course">Courses</div>
        </a>
      <!--   <div id="course"> Courses </div> -->
           
       
        <div id="learning">
            <a id="learning-link" class="learn" href="My_Learning.php">My Learning</a>
        </div>

        <div id="nav-icon"> 
            <button class="user-button"> 
                <i class="fa-solid fa-circle-user"></i>
            </button>
        </div>
</div>

    <?php
    session_start(); // Start the session

    include '../database_connection/db_connection.php';

    // Check if student_id is set in the session
    if (!isset($_SESSION['student_id'])) {
        echo 'Student ID not found. Please log in.';
        exit; // Stop execution if the session variable is not set
    }

    $student_id = $_SESSION['student_id']; // Get student_id from session

    // Fetch the courses the student has applied for
    $query = "
        SELECT c.title, c.code, ca.application_date 
        FROM course_applications ca
        JOIN courses2 c ON ca.course_id = c.id
        WHERE ca.student_id = ?
    ";

    $stmt = $conn->prepare($query);
    
    // Check if statement preparation was successful
    if (!$stmt) {
        echo "Error preparing statement: " . $conn->error;
        exit;
    }

    $stmt->bind_param("i", $student_id);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        echo '<div class="course-container">'; // Container for all courses
        while ($row = $result->fetch_assoc()) {
            echo '<div class="course-item">'; // Container for each course
            echo '<h2 class="course-title">' . htmlspecialchars($row['title']) . '</h2>';
            echo '<p class="course-code">Code: ' . htmlspecialchars($row['code']) . '</p>';
            echo '<p class="application-date">Applied on: ' . htmlspecialchars($row['application_date']) . '</p>';
            echo '</div>'; // End of course-item
        }
        echo '</div>'; // End of course-container
    } else {
        echo '<p>No courses applied.</p>';
    }

    $stmt->close();
    $conn->close();
    ?>
</body>
</html>