<?php
// logout.php - Update logout time when the user logs out

session_start();
include '../database_connection/db_connection.php';

if (isset($_SESSION['admin']) || isset($_SESSION['student_mid'])) {
    // Capture logout time
    $logout_time = date("Y-m-d H:i:s");
    $user_id = isset($_SESSION['admin']) ? $_SESSION['admin'] : $_SESSION['student_id']; // Use appropriate user ID

    // Update logout time in the login_activity table for the current session user
    $logout_query = "UPDATE login_activity SET logout_time = '$logout_time' WHERE user_id = '$user_id' AND logout_time IS NULL";
    mysqli_query($conn, $logout_query);

    // Destroy session and redirect to login page
    session_unset();
    session_destroy();
    header("Location: login.php");
    exit();
}
?>
