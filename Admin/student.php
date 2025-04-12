<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Student List</title>
    <link rel="stylesheet" href="student.css">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>   
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css" integrity="sha512-Kc323vGBEqzTmouAECnVceyQqyqdsSiqLQISBL29aUW4U/M7pSPA/gEUZQqv1cwx4OnYxTxve5UMg5GT6L4JJg==" crossorigin="anonymous" referrerpolicy="no-referrer" />
</head>
<body>
    <div class="navbar">
        <div id="aisc"> AISC </div>
        
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
                <a id="home-icon" href="/Admin/home.php"><i class="fa-solid fa-house"></i> Home </a>
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
                <a id="course-icon" href="/Admin/course.php"> <i class="fa-sharp-duotone fa-solid fa-list"></i> Course </a> 
                <div class="menu-divider"></div>
            </li>
        </ul>
    </div>

    <div id="main-content">
        <div class="breadcrumb">
            <ul>
                <li>
                <i class="fa-solid fa-bars"></i>
                    Student List
                </li>
            </ul>
        </div>

        <div class="s1-button">
            <button style="background-color: blueviolet;" id="upload" onclick="openModal()">
                <i class="fa-solid fa-plus"></i>
                Bulk Upload
            </button>
            
            <button style="background-color: crimson;" id="add" onclick="window.location.href='add_student_form.php';">
                <i class="fa-solid fa-plus"></i>
                Add
            </button>
        </div>

        <!-- Bulk Upload Modal -->
        <div id="bulkupload" class="modal">
            <div class="modal-content">
                <span class="close" onclick="closeModal()">&times;</span>

                <div>
                    <a href="download_template.php" class="btn-template">Download Template</a>
                </div>

                <form action="upload_students.php" method="POST" enctype="multipart/form-data">
                    <label for="file">Choose a file (CSV or Excel):</label>
                    <input type="file" name="file" accept=".csv, .xlsx" required>
                    <button type="submit" class="btn-upload">Upload</button>
                </form>
            </div>
        </div>

        <div class="filter">
            <form method="GET" action="student.php">
                <input type="text" id="search" name="search" placeholder="search for student name">
                <select id="filterfaculty" name="filterfaculty">
                    <option value=""> Filter By Faculty </option>
                    <option> ARTS </option>
                    <option> COMMERCE </option>
                    <option> SCIENCE </option>
                    <option> BCS </option>
                    <option> BBA </option>
                    <option> BCA SCIENCE</option>
                </select>
                <select id="filterclass" name="filterclass">
                    <option value=""> Filter By Class </option>
                    <option> UG-F.Y </option>
                    <option> UG-S.Y </option>
                    <option> UG-TY </option>
                    <option> PG-F.Y </option>
                    <option> PG-S.Y </option>
                    <option> PG-T.Y </option>
                </select>
                <button id="apply" type="submit"> Apply </button>  
                <button id="clear"> Clear </button>
            </form>   
        </div>

        <table class="table-class" border="2px">
            <thead>
                <tr>
                    <th>No</th>
                    <th>MID</th>
                    <th>Name</th>
                    <th>Email</th>
                    <th>Mobile Number</th>
                    <th>Class</th>
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

                // Get filter parameters from the URL (if any)
                $search = isset($_GET['search']) ? "%" . $conn->real_escape_string($_GET['search']) . "%" : "";
                $faculty = isset($_GET['filterfaculty']) ? $conn->real_escape_string($_GET['filterfaculty']) : "";
                $class = isset($_GET['filterclass']) ? $conn->real_escape_string($_GET['filterclass']) : "";

                // Prepare the base SQL query with JOIN
                $sql = "SELECT sa.* 
                        FROM student_admin sa
                        LEFT JOIN student_courses sc ON sa.id = sc.student_id
                        LEFT JOIN courses c ON sc.course_id = c.id
                        WHERE 1=1";

                // Add conditions based on the search term and filters
                if (!empty($search)) {
                    $sql .= " AND (CONCAT(sa.firstname, ' ', sa.lastname) LIKE ? OR sa.firstname LIKE ? OR sa.lastname LIKE ?)";
                }
                if (!empty($faculty)) {
                    $sql .= " AND sa.select_faculty = ?";
                }
                if (!empty($class)) {
                    $sql .= " AND sa.select_class = ?";
                }

                // Add pagination limit
                $sql .= " GROUP BY sa.id LIMIT ?, ?";

                // Prepare and bind parameters
                $stmt = $conn->prepare($sql);
                if ($stmt === false) {
                    die('Prepare failed: ' . htmlspecialchars($conn->error));
                }

                $param_types = '';
                $params = [];

                // Bind search parameters
                if (!empty($search)) {
                    $param_types .= 'sss';
                    $params[] = $search;
                    $params[] = $search;
                    $params[] = $search;
                }
                // Bind filter parameters
                if (!empty($faculty)) {
                    $param_types .= 's';
                    $params[] = $faculty;
                }
                if (!empty($class)) {
                    $param_types .= 's';
                    $params[] = $class;
                }

                // Bind pagination parameters
                $param_types .= 'ii';
                $params[] = $start;
                $params[] = $limit;

                $stmt->bind_param($param_types, ...$params);
                $stmt->execute();
                $result = $stmt->get_result();

                if ($result->num_rows > 0) {
                    $no = $start + 1;
                    while ($row = $result->fetch_assoc()) {
                        echo "<tr>";
                        echo "<td>" . $no++ . "</td>";
                        echo "<td>" . htmlspecialchars($row['mid']) . "</td>";
                        echo "<td>" . htmlspecialchars($row['firstname'] . ' ' . $row['lastname']) . "</td>";
                        echo "<td>" . htmlspecialchars($row['email']) . "</td>";
                        echo "<td>" . htmlspecialchars($row['mobile_number']) . "</td>";
                        echo "<td>" . htmlspecialchars($row['select_class']) . "</td>";
                        echo "<td>" . htmlspecialchars($row['select_faculty']) . "</td>";
                        echo "<td>
                            <div class='dropdown'>
                                <button onclick='showDropdown(this)'>Action</button>
                                <div class='dropdown-content'>

                                    <a href='/Admin/student_Edit.php?mid=" . htmlspecialchars($row['mid']) . "'>Edit</a>
                                     <a href='#' onclick='confirmDelete(" . htmlspecialchars($row['id']) . ", \"" . htmlspecialchars($row['firstname'] . ' ' . $row['lastname']) . "\")'>Delete</a>


                                </div>
                            </div>
                        </td>";
                        echo "</tr>";
                    }
                } else {
                    echo "<tr><td colspan='8'>No records found</td></tr>";
                }

                // Pagination logic
                $stmt->close();

                // Count total records for pagination
                $sqlCount = "SELECT COUNT(*) as total FROM student_admin WHERE 1=1";
                $stmtCount = $conn->prepare($sqlCount);
                $stmtCount->execute();
                $resultCount = $stmtCount->get_result();
                $totalRecords = $resultCount->fetch_assoc()['total'];
                $totalPages = ceil($totalRecords / $limit);

                echo '<div class="pagination">';
                if ($page > 1) {
                    echo '<a href="?page=' . ($page - 1) . '&search=' . urlencode($_GET['search'] ?? '') . '&filterfaculty=' . urlencode($_GET['filterfaculty'] ?? '') . '&filterclass=' . urlencode($_GET['filterclass'] ?? '') . '">Previous</a>';
                }

                for ($i = 1; $i <= $totalPages; $i++) {
                    echo '<a href="?page=' . $i . '&search=' . urlencode($_GET['search'] ?? '') . '&filterfaculty=' . urlencode($_GET['filterfaculty'] ?? '') . '&filterclass=' . urlencode($_GET['filterclass'] ?? '') . '">' . $i . '</a>';
                }

                if ($page < $totalPages) {
                    echo '<a href="?page=' . ($page + 1) . '&search=' . urlencode($_GET['search'] ?? '') . '&filterfaculty=' . urlencode($_GET['filterfaculty'] ?? '') . '&filterclass=' . urlencode($_GET['filterclass'] ?? '') . '">Next</a>';
                }
                echo '</div>';

                $conn->close();
                ?>
            </tbody>
        </table>
    </div>

    <!-- <script>
        function toggleDropdown() {
            const dropdown = document.getElementById('logout-dropdown');
            dropdown.style.display = dropdown.style.display === 'block' ? 'none' : 'block';
        }

        function confirmLogout() {
            Swal.fire({
                title: 'Are you sure?',
                text: 'You will be logged out!',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes, logout!'
            }).then((result) => {
                if (result.isConfirmed) {
                    // Perform the logout action
                    window.location.href = '../User_registration/user.php'; // Adjust the path to your logout script
                }
            });
        }

        function confirmDelete(id) {
            Swal.fire({
                title: 'Are you sure?',
                text: 'This will delete the student record!',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes, delete it!'
            }).then((result) => {
                if (result.isConfirmed) {
                    // Redirect to delete action
                    window.location.href = 'delete_student.php?id=' + id; 
                }
            });
        }

        function openModal() {
            document.getElementById("bulkupload").style.display = "block";
        }

        function closeModal() {
            document.getElementById("bulkupload").style.display = "none";
        }

        function showDropdown(button) {
            const dropdownContent = button.nextElementSibling;
            dropdownContent.style.display = dropdownContent.style.display === 'block' ? 'none' : 'block';
        }
    </script> -->
    <script src="/Javascript/script.js"></script>
</body>
</html>
