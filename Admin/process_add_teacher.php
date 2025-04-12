<?php
include '../database_connection/db_connection.php';

$first_name = $_POST['first_name'];
$last_name = $_POST['last_name'];
$email = $_POST['email'];
$faculty = $_POST['faculty'];
$department = $_POST['department'];
$designation = $_POST['designation'];
$mid = $_POST['mid'];

$sql = "INSERT INTO teachers (first_name, last_name, email, faculty, department, designation, mid) 
        VALUES ('$first_name', '$last_name', '$email', '$faculty', '$department', '$designation', '$mid')";

if ($conn->query($sql) === TRUE) {
    header("Location: teacher.php"); // Redirect back to the teacher list page after successful insertion
} else {
    echo "Error: " . $sql . "<br>" . $conn->error;
}

$conn->close();
?>
