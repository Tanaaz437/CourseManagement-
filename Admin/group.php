<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>AISC</title>
    <link rel="stylesheet" href="grooup.css">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>   
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css" integrity="sha512-Kc323vGBEqzTmouAECnVceyQqyqdsSiqLQISBL29aUW4U/M7pSPA/gEUZQqv1cwx4OnYxTxve5UMg5GT6L4JJg==" crossorigin="anonymous" referrerpolicy="no-referrer" />

</head>
<body>
    <div class="navbar">
        <div id="aisc">AISC</div>
        
        <div id="nav-icon"><!-- logout -->
        <button class="user-button" onclick="toggleDropdown()">
            <i class="fa-solid fa-circle-user"></i>
        </button>

        <div id="logout-dropdown" class="logout-dropdown" style="display: none;">
            <a href="#" onclick="confirmLogout()">Logout</a>
        </div>

        </div>
    </div>
    <div class="sidebar">
        <ul class="menu">
        <li class="home">
                <a id="home-icon" href="/Admin/home.php"> <i class="fa-solid fa-house"></i>Home</a>
                <div class="menu-divider"> </div>
            </li>

            <li class="teacher">
                <a id="teacher-icon" href="/Admin/teacher.php"> <i class="fa-solid fa-users"></i> Teacher</a> 
                <div class="menu-divider"> </div>
            </li>

            <li class="student">
                <a id="student-icon" href="/Admin/student.php"> <i class="fa-solid fa-users"></i> Student</a> 
                <div class="menu-divider"> </div>
            </li>

            <li class="group">
                <a id="group-icon" href="/Admin/group.php"> <i class="fa-sharp-duotone fa-solid fa-list"></i> Group</a> 
                <div class="menu-divider"> </div>
            </li>

            <li class="course">
                <a id="course-icon" href="/Admin/course.php"> <i class="fa-sharp-duotone fa-solid fa-list"></i> Course </a> 
                <div class="menu-divider"> </div>
            </li>

            

        </ul>
    </div>
    <div id="main-content">
        <div class="breadcrumb">
            <ul>
                <li><i class="fa-solid fa-bars"></i> Group List</li>
            </ul>
        </div>
        <div class="add-teacher">
            <ul>
                <li><a href="add_group.php" id="add-group-btn"><i class="fa-solid fa-plus"></i> Add</a></li>
            </ul>
        </div>
        <!-- group slots -->
        <div class="group-list" id="group-list">
            <?php
            include '../database_connection/db_connection.php';
            $result = $conn->query("SELECT * FROM groupslots");

            if ($result->num_rows > 0) {
                while($row = $result->fetch_assoc()) {
                    echo '<div class="group-item">';
                    echo '<h2>' . htmlspecialchars($row['name']) . '</h2>';
                    echo '<i class="fa-solid fa-ellipsis-vertical menu-button"></i>';
                    echo '<div class="group-menu">';
                    echo '<ul>';
                    echo '<li class="edit-option"><a href="edit_group.php?id=' . $row['id'] . '">Edit</a></li>';
                    echo '<li class="delete-option"><a href="process_delete_group.php?id=' . $row['id'] . '">Delete</a></li>';
                    echo '</ul>';
                    echo '</div>';
                    echo '</div>';
                }
            } else {
                echo 'No groups found.';
            }

            $conn->close();
            ?>
        </div>
    </div>

<script src="/Javascript/script.js"></script>
</body>
</html>
