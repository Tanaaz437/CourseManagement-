<?php
include '../database_connection/db_connection.php';

// Get data from POST request
$teacher_id = isset($_POST['id']) ? intval($_POST['id']) : 0;
$mid = isset($_POST['mid']) ? $_POST['mid'] : '';
$first_name = isset($_POST['first_name']) ? $_POST['first_name'] : '';
$last_name = isset($_POST['last_name']) ? $_POST['last_name'] : '';
$email = isset($_POST['email']) ? $_POST['email'] : '';
$designation = isset($_POST['designation']) ? $_POST['designation'] : '';
$faculty = isset($_POST['faculty']) ? $_POST['faculty'] : '';
$department = isset($_POST['department']) ? $_POST['department'] : '';

if ($teacher_id > 0) {
    // Prepare SQL statement to update the teacher's details
    $sql = "UPDATE teachers SET mid = ?, first_name = ?, last_name = ?, email = ?, designation = ?, faculty = ?, department = ? WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param('issssssi', $mid, $first_name, $last_name, $email, $designation, $faculty, $department, $teacher_id);

    if ($stmt->execute()) {
        echo "Teacher updated successfully!";
      header('Location:teacher.php');
       
       
    } else {
        echo "Error updating teacher details.";
    }

    $stmt->close();
} else {
    echo "Invalid teacher ID.";
}

$conn->close();
?>
