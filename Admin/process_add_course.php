<?php
     include '../database_connection/db_connection.php';

$code = $_POST['code'];
$title = $_POST['title'];
$faculty = $_POST['faculty'];
/* $visible = $_POST['visible']; */
$group = $_POST['group'];
$summary = $_POST['summary'];
$studentlimit = $_POST['studentlimit'];



$sql = "INSERT INTO courses2 (code, title, faculty, `group`, summary, `studentlimit`)
       VALUES ('$code','$title','$faculty','$group','$summary','$studentlimit')";

if ($conn->query($sql) === TRUE) {
    header("Location: course.php"); // Redirect back to the teacher list page after successful insertion
} else {
    echo "Error: " . $sql . "<br>" . $conn->error;
}

$conn->close();
?>