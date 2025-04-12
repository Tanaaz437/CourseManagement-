<?php
error_reporting(0);
ini_set('display_errors',0);

session_start();
include '../database_connection/db_connection.php';
$error_message = "";
$lastActiveMessage = "";

// Function to log errors to a log file
function logError($message) {
    /* error_log($message, 3, '/path/to/your/error_log.txt'); */ 
     // Update this to a valid path for logging
     error_log($message);
}

// Function to get user's IP address
function getUserIp() {
    if (!empty($_SERVER['HTTP_CLIENT_IP'])) {
        return $_SERVER['HTTP_CLIENT_IP'];
    } elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) {
        return $_SERVER['HTTP_X_FORWARDED_FOR'];
    } else {
        return $_SERVER['REMOTE_ADDR'];
    }
}

// Function to get device/browser information
function getUserDevice() {
    return $_SERVER['HTTP_USER_AGENT'];  // This will give you the browser and OS information
}

// Check if the user is logging in
if ($_SERVER['REQUEST_METHOD'] == 'POST' && !empty($_POST['username'])) {
    $username = mysqli_real_escape_string($conn, $_POST['username']);
    $password = mysqli_real_escape_string($conn, $_POST['password']);
    date_default_timezone_set('Asia/Kolkata');

    // Capture user login details
    $loginTime = date('Y-m-d H:i:s');
    $userIp = getUserIp();  // Get the user's IP address
    $deviceInfo = getUserDevice();  // Get the user's device information



      // Admin login check
      if ($username === 'Tanaaz' && $password === 'admin123') {
        $_SESSION['admin'] = $username;

        // Log admin login
        logError("Admin logged in at $loginTime from IP: $userIp using device: $deviceInfo");

        // Redirect to admin home page
        header("Location: /Admin/home.php");
        exit();
    }

    // Check for student login
    $query = "SELECT * FROM student_admin WHERE REPLACE(CONCAT(firstname, lastname), ' ', '') = '$username' AND mid = '$password'";
    $result = mysqli_query($conn, $query);

    if ($result && mysqli_num_rows($result) > 0) {
        // Student login
        $student = mysqli_fetch_assoc($result);
        $_SESSION['student_mid'] = $student['mid'];
        $_SESSION['student_id'] = $student['id'];  // Store student_id in session

        // Update last login time, last seen time, IP, and device information for the student
        $updateLoginQuery = "UPDATE student_admin SET last_login = '$loginTime', last_seen = '$loginTime', last_ip = '$userIp', device_info = '$deviceInfo' WHERE id = {$student['id']}";
        
        // Debugging: Log the query to ensure it's being executed
        logError("Student login query: " . $updateLoginQuery);

        if (mysqli_query($conn, $updateLoginQuery)) {
            logError("Student login details updated successfully.");
        } else {
            $error_message = "Error updating student login time: " . mysqli_error($conn);
            logError($error_message);  // Log the error
            echo $error_message;  // Optionally display the error to the user
        }

        // Fetch last logout time
        $lastActiveMessage = $student['last_logout'] ? "Last active: " . $student['last_logout'] : "Last active: Never";

        // Redirect to student courses page
        header("Location: ../Student_Select_courses/Select_courses.php");
        exit();
    }

    // Check for teacher login
    $query = "SELECT * FROM teachers WHERE REPLACE(CONCAT(first_name, last_name), ' ', '') = '$username' AND mid = '$password'";
    $result = mysqli_query($conn, $query);

    if ($result && mysqli_num_rows($result) > 0) {
        // Teacher login
        $teacher = mysqli_fetch_assoc($result);
        $_SESSION['admin'] = $username;  // Store teacher admin session

        // Update last login time, last seen time, IP, and device information for the teacher
        $updateLoginQuery = "UPDATE teachers SET last_login = '$loginTime', last_seen = '$loginTime', last_ip = '$userIp', device_info = '$deviceInfo' WHERE REPLACE(CONCAT(first_name, last_name), ' ', '') = '$username'";

        // Debugging: Log the query to ensure it's being executed
        logError("Teacher login query: " . $updateLoginQuery);

        if (mysqli_query($conn, $updateLoginQuery)) {
            logError("Teacher login details updated successfully.");
        } else {
            $error_message = "Error updating teacher login time: " . mysqli_error($conn);
            logError($error_message);  // Log the error
            echo $error_message;  // Optionally display the error to the user
        }

        // Fetch last logout time
        $lastActiveMessage = $teacher['last_logout'] ? "Last active: " . $teacher['last_logout'] : "Last active: Never";

        // Redirect to admin home page
        header("Location: /Admin/home.php");
        exit();
    } else {
        
        $error_message = "Invalid Credentials";
        logError($error_message);  // Log the error
        echo $error_message;  // Optionally display the error to the user
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CC Courses</title>
    <link rel="stylesheet" href="/style/style.css">
</head>
<body>
    <div class="main-page">
        <div class="form-container">
            <div class="form-section">
                <form method="post">
                    <h2>Login Page</h2>

                    <label  for="student-username">ENTER  MID  OR  USER-NAME</label>
                    <div class="input-container">
                        <input type="text" id="student-username" name="username" value="<?= isset($_POST['username']) ? htmlspecialchars($_POST['username']) : '' ?>" required>
                       
                    </div>

                    <label for="student-password">PASSWORD</label>
                    <div class="input-container">
                        <input type="password" id="student-password" name="password" required>
                        <i class="fas fa-eye" id="togglePassword"></i>
                    </div>

         <!--            <div class="input-row">
                 <label for="password">Password:</label>
                <div class="input-container">
        <input type="password" id="password" placeholder="Enter your password">
        <i class="fas fa-eye" id="togglePassword"></i>
        </div> -->
            </div>


                    <button type="submit" class="btn">Login</button>

                    <?php if (!empty($error_message)): ?>
                       <!--  <p class="error-message"><?= htmlspecialchars($error_message) ?></p> -->
                       <div class="error-message">
                        <?= htmlspecialchars($error_message) ?>
                     </div>
                    <?php endif; ?>

                </form>
                
            </div>
        </div>
    </div>  

    <?php if (!empty($lastActiveMessage)): ?>

        <script>
            alert("<?= $lastActiveMessage ?>");
        </script>
    <?php endif; ?>
    <script src="/Javascript/script.js"></script>
</body>
</html>
