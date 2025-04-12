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
    $id = $conn->insert_id;
    $no = $conn->query("SELECT COUNT(*) AS count FROM teacher")->fetch_assoc()['count'];
    echo json_encode([
        'success' => true,
        'id' => $id,
        'no' => $no,
        'first_name' => $first_name,
        'last_name' => $last_name,
        'email' => $email,
        'faculty' => $faculty,
        'designation' => $designation,
        'mid' => $mid
    ]);
} else {
    echo json_encode(['success' => false]);
}

$conn->close();
?>
