<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>AISC</title>
    <link rel="stylesheet" href="adminStyle.css">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@600&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css" integrity="sha512-Kc323vGBEqzTmouAECnVceyQqyqdsSiqLQISBL29aUW4U/M7pSPA/gEUZQqv1cwx4OnYxTxve5UMg5GT6L4JJg==" crossorigin="anonymous" referrerpolicy="no-referrer" />
</head>
<body>

<div class="navbar">
    <div id="aisc">AISC</div>

    <div id="nav-icon"> <!-- logout -->
        <button class="user-button" onclick="toggleDropdown()">
            <i class="fa-solid fa-circle-user"></i>
        </button>
        <!-- Logout dropdown -->
        <div id="logout-dropdown" class="dropdown-content" style="display: none;">
            <button onclick="confirmLogout()">Logout</button>
        </div>
    </div>
</div>

<div class="sidebar">
    <ul class="menu">
        <li class="home">
            <a id="home-icon" href="/Admin/home.php"> <i class="fa-solid fa-house"></i> Home </a>
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
            <a id="course-icon" href="/Admin/course.php"> <i class="fa-sharp-duotone fa-solid fa-list"></i> Course</a>
            <div class="menu-divider"></div>
        </li>
        <!-- Course status section -->
        <li class="course-status">
        <a id="course-status-icon" href="/Admin/course_status.php"> <i class="fa-solid fa-list"></i> Course Status</a>
        <div class="menu-divider"></div>
        </li>

        <li>
            <a id="email-template" href="/Admin/emailTemplate.php"><i class="fa-solid fa-list"></i>Email Template</a>
            <div class="menu-divider"></div>
        </li>
    </ul>
</div>

<div id="main-content">
    <div class="breadcrumb">
        <ul>
            <li>
                <i class="fa-solid fa-house"></i> Home
            </li>
        </ul>
    </div>
</div>

<script src="/Javascript/script.js"></script>

</body>
</html>
