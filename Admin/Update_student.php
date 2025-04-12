<?php
include '../database_connection/db_connection.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Get student ID and other details from the POST request
    $student_id = intval($_POST['student_id']);
    $mid = $_POST['mid'];
    $firstname = $_POST['firstname'];
    $lastname = $_POST['lastname'];
    $email = $_POST['email'];
    $mobile_number = $_POST['mobile_number'];
    $select_class = $_POST['select_class'];
    $select_faculty = $_POST['select_faculty'];

    // Prepare and execute the update query
    $sql = "UPDATE student_admin SET mid = ?, firstname = ?, lastname = ?, email = ?, mobile_number = ?, select_class = ?, select_faculty = ? WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param('sssssssi', $mid, $firstname, $lastname, $email, $mobile_number, $select_class, $select_faculty, $student_id);

    if ($stmt->execute()) {
        // Redirect or inform success
        header("Location: student.php");
        exit();
    } else {
        die("Error updating student: " . $conn->error);
    }

    $stmt->close();
} else {
    die("Invalid request method.");
}
?>
