<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Teacher Management</title>
    <link rel="stylesheet" href="/Admin/teacher.css">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>   
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css" integrity="sha512-Kc323vGBEqzTmouAECnVceyQqyqdsSiqLQISBL29aUW4U/M7pSPA/gEUZQqv1cwx4OnYxTxve5UMg5GT6L4JJg==" crossorigin="anonymous" referrerpolicy="no-referrer" />
</head>
<body>
    <div class="navbar">
        <div id="aisc">AISC</div>

        <div id="nav-icon">
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
                <!-- /Teacher/home.php -->
                <a id="home-icon" href="/Admin/home.php"><i class="fa-solid fa-house"></i> Home</a>
                <div class="menu-divider"></div>
            </li>
            <li class="teacher">
                <!-- /Admin/teacher.php -->
                <a id="teacher-icon" href="/Admin/teacher.php"><i class="fa-solid fa-users"></i> Teacher</a>
                <div class="menu-divider"></div>
            </li>
            <li class="student">
                <!-- /Admin/student.php" -->
                <a id="student-icon" href="/Admin/student.php"><i class="fa-solid fa-users"></i> Student</a>
                <div class="menu-divider"></div>
            </li>
            <li class="group">
                <!-- Admin/group.php -->
                <a id="group-icon" href="/Admin/group.php"><i class="fa-sharp-duotone fa-solid fa-list"></i> Group</a>
                <div class="menu-divider"></div>
            </li>
            <li class="course">
                <a id="course-icon" href="/Admin/course.php"><i class="fa-sharp-duotone fa-solid fa-list"></i> Course</a>
                <div class="menu-divider"></div>
            </li>
            
        </ul>
    </div>

    <div id="main-content">
        <div class="breadcrumb">
            <ul>
                <li>
                    <i class="fa-solid fa-bars"></i>
                    Teacher List
                </li>
            </ul>
        </div>

        <div class="add-teacher">
            <ul>
                <li>
                    <!-- add_teacher_form.php -->
                    <a href="/Admin/add_teacher_form.php"><i class="fa-solid fa-plus"></i> Add</a>
                </li>
            </ul>
        </div>

        <table class="table-class" border="1px">
            <thead>
                <tr>
                    <th>No</th>
                    <th>MID</th>
                    <th>Name</th>
                    <th>Email</th>
                    <th>Designation</th>
                    <th>Faculty</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
            <?php
            include '../database_connection/db_connection.php';

            // Pagination variables
            $limit = 5;
            $page = isset($_GET['page']) ? intval($_GET['page']) : 1;
            $start = ($page - 1) * $limit;

            // Get total number of records
            $result_total = $conn->query("SELECT COUNT(*) AS total FROM teachers");
            $total = $result_total->fetch_assoc()['total'];
            $total_pages = ceil($total / $limit);

            // Fetch records with pagination
            $sql = "SELECT * FROM teachers LIMIT ?, ?";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param('ii', $start, $limit);
            $stmt->execute();
            $result = $stmt->get_result();

            if ($result->num_rows > 0) {
                $no = $start + 1;
                while ($row = $result->fetch_assoc()) {
                    echo "<tr>";
                    echo "<td>" . $no++ . "</td>";
                    echo "<td>" . htmlspecialchars($row['mid']) . "</td>";
                    echo "<td>" . htmlspecialchars($row['first_name'] . ' ' . $row['last_name']) . "</td>";
                    echo "<td>" . htmlspecialchars($row['email']) . "</td>";
                    echo "<td>" . htmlspecialchars($row['designation']) . "</td>";
                    echo "<td>" . htmlspecialchars($row['faculty']) . "</td>";
                    echo "<td>";
                    echo "<a href='Teacher_Edit.php?id=" . htmlspecialchars($row['id']) . "'><button>Edit</button></a>";
                    echo "<button onclick='deleteTeacher(" . htmlspecialchars($row['id']) . ")'>Delete</button>";
                    echo "</td>";
                    echo "</tr>";
                }
            }else {
                echo "<tr><td colspan='7'>No records found</td></tr>";
            }

            $stmt->close();
            $conn->close();
            ?>
            </tbody>
        </table>

        <!-- Pagination controls -->
        <div class="pagination">
            <?php if ($page > 1): ?>
                <a href="teacher.php?page=<?php echo $page - 1; ?>">&#171; Previous</a>
            <?php endif; ?>

            <?php for ($i = 1; $i <= $total_pages; $i++): ?>
                <a href="teacher.php?page=<?php echo $i; ?>" <?php if ($i === $page) echo 'class="active"'; ?>><?php echo $i; ?></a>
            <?php endfor; ?>

            <?php if ($page < $total_pages): ?>
                <a href="teacher.php?page=<?php echo $page + 1; ?>">Next &#187;</a>
            <?php endif; ?>
        </div>
    </div>

   
<script src="/Javascript/script.js"></script>
</body>

</html>
