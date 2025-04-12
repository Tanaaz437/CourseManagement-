<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>AISC</title>
    <link rel="stylesheet" href="/Student_Select_courses/Select_course.css">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@600&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css" integrity="sha512-Kc323vGBEqzTmouAECnVceyQqyqdsSiqLQISBL29aUW4U/M7pSPA/gEUZQqv1cwx4OnYxTxve5UMg5GT6L4JJg==" crossorigin="anonymous" referrerpolicy="no-referrer" /></head>
<body>
    <?php

use PhpOffice\PhpSpreadsheet\Calculation\Statistical\Distributions\StudentT;

    session_start(); // Start the session at the beginning of the file

    // Check if student_id is set in the session
    if (!isset($_SESSION['student_id'])) {
        echo 'Student ID not found. Please log in.';
        exit; // Stop execution if the session variable is not set
    }

    $student_id = $_SESSION['student_id']; // Get student_id from session
    ?>

<div class="navbar">
    <div id="aisc">AISC</div>
    <div id="navbar-links">
        <a href="My_Learning.php">My Learning</a>
        <a href="/Student_Select_courses/My_Learning.php">Courses</a>
        <!-- E-certifaicate download button -->
        <button id="downloadButton" class="download-btn download-btn-inactive" onclick="handleDownload()">Download Certificate</button>
        
    </div>
    <div id="nav-icon">   <!-- logout --> 
        <button class="user-button" onclick="toggleDropdown()">
            <i class="fa-solid fa-circle-user"></i>
        </button>
        <div id="logout-dropdown" class="logout-dropdown" style="display: none;">
            <a href="#" onclick="confirmLogout()">Logout</a>
        </div>
     </div>
</div>
<!--  Random Fun fact -->
<div class="wrapper">

    <span>&#128161;</span>
    <button id="joke-button">Get a Random Facts</button>
    <p id="joke-display"></p>

</div>
    <input type="hidden" id="studentId" value="<?php echo $student_id; ?>">
    <div id="main-content">
        <div class="group-list" id="group-list">
        <div class="course-list" id="course-list">
            <?php
            include '../database_connection/db_connection.php';

            // Fetch the number of applications and course IDs applied for by the student
            $appliedCourses = [];
            $applicationCount = 0;
            $appQuery = $conn->prepare("SELECT course_id FROM course_applications WHERE student_id = ?");
            $appQuery->bind_param("i", $student_id);
            $appQuery->execute();
            $appResult = $appQuery->get_result();
            while ($appRow = $appResult->fetch_assoc()) {
                $appliedCourses[] = $appRow['course_id'];
                $applicationCount++;
            }
            $appQuery->close();
            // Fetching group slots
            $query = "SELECT * FROM groupslots";
            if ($result = $conn->query($query)) {
                if ($result->num_rows > 0) {
                    while ($row = $result->fetch_assoc()) {
                        echo '<div class="group-item">';
                        echo '<h2>GROUP : ' . htmlspecialchars($row['name']) . '</h2>';
                        echo '<div class="group-menu">';
                        echo '</div>';
                        echo '</div>';
                    }
                } else{
                    echo 'No groups found.';
                }
                $result->free();
            } else {
                echo 'Error executing query: ' . $conn->error;
            }


         // Fetching courses
            $query = "SELECT * FROM courses2";
            if ($result = $conn->query($query)) {
                if ($result->num_rows > 0) {
                    while ($row = $result->fetch_assoc()) {
                        $courseId = $row['id'];
                        $isApplied = in_array($courseId, $appliedCourses);
                        $canApply = !$isApplied && $applicationCount < 2;
                        
                        echo '<div class="course-item">';
                        echo '<div class="course-content">';
                        echo '<img src="/images/book1.webp" alt="Course Image" class="course-image">';
                        echo '<div class="course-info">';
                        echo '<h2>Course: ' . htmlspecialchars($row['title']) . '</h2>';
                        echo '<p>Code: ' . htmlspecialchars($row['code']) . '</p>';
                        echo '</div>';
                        echo '</div>';
                        
                        if ($isApplied) {
                            echo '<span class="applied-label">Applied</span>';
                        } else {
                            echo '<a href="#" class="view-details" onclick="openModal(\'' . htmlspecialchars($row['title']) . '\', \'' . htmlspecialchars($row['faculty']) . '\', \'' . htmlspecialchars($row['group']) . '\', \'' . htmlspecialchars($row['summary']) . '\', \'' . $courseId . '\', ' . ($canApply ? 'true' : 'false') . ')">View Details</a>';
                        }

                        echo '</div>';
                    }
                } else {
                    echo 'No courses found.';
                }
                $result->free();
            } else {
                echo 'Error executing query: ' . $conn->error;
            }

/* Certificate */
            $certificateApproved=false;
            $certificateApprovedQuery ="Select certificate_approved from stud_cour where student_id=? And certificate_approved='Yes'";
            $cerstm=$conn->prepare($certificateApprovedQuery);
            $cerstm->bind_param("i",$student_id);
            $cerstm->execute();
            $result=$cerstm->get_result();

            if($result->num_rows>0){
                $certificateApproved=true;
            }
            $cerstm->close();

            $conn->close();
            ?>
            </div>
        </div>

        <!-- Modal structure -->
        <div id="courseModal" class="modal">
            <div class="modal-content">
                <span class="close" onclick="closeModal()">&times;</span>
                <h2 id="modalTitle" class="modal-title">Course Title</h2>
                <div class="modal-body">
                    <p id="modalFaculty">Faculty</p>
                    <p id="modalGroup">Group</p>
                    <p id="modalSummary">Summary</p>
                </div>  
                <div class="modal-buttons">
                    <button id="applyBtn" onclick="applyAction()" class="apply-btn">Apply</button>
                    <button onclick="closeModal()" class="close-btn">Close</button>
                </div>
            </div>
        </div>
    </div>

<script src="/Javascript/script.js"></script>
<script>

document.addEventListener('DOMContentLoaded', function () {
    const jokeButton = document.getElementById('joke-button');
    const jokeDisplay = document.getElementById('joke-display');

    jokeButton.addEventListener('click', function () {
        fetch('https://uselessfacts.jsph.pl/random.json?language=en')
            .then(response => response.json())
            .then(data => {
                console.log("Fun Fact API Response:", data); // Debugging: Check API response

                if (data.text) {
                    jokeDisplay.innerHTML = `<strong>Fun Fact:</strong> ${data.text}`;
                } else {
                    jokeDisplay.textContent = "No fun fact found. Try again!";
                }
            })
            .catch(error => {
                jokeDisplay.textContent = "Failed to fetch fun fact. Check console.";
                console.error("Error fetching fun fact:", error);
            });
    });
});
const downloadButton=document.getElementById('downloadButton');
    const isCertificateApproved=<?php   echo  $certificateApproved ? 'true':'false'; ?>

    if(isCertificateApproved){
        downloadButton.classList.remove('download-btn-inactive');
        downloadButton.classList.add('download-btn-active');
        downloadButton.innerText = 'Download Certificate';

    }else{
        downloadButton.classList.remove('download-btn-active');
        downloadButton.classList.add('download-btn-inactive');
        downloadButton.innerText = 'Waiting for Approval';
        downloadButton.setAttribute('disabled', 'true');
    }

    function handleDownload(){
        if(isCertificateApproved){
            window.location.href = '/Admin/download_certificate.php';
            
        }else{
            Swal.fire({
            title: 'Approval Pending',
            text: 'Your certificate is not approved yet. Please wait for the teacher to approve it.',
            icon: 'info',
            confirmButtonText: 'OK'
        });
        }
}
function openModal(title, faculty, group, summary, courseId, canApply) {
    document.getElementById('modalTitle').innerText = title;
    document.getElementById('modalFaculty').innerText = "Faculty: " + faculty;
    document.getElementById('modalGroup').innerText = "Group: " + group;
    document.getElementById('modalSummary').innerText = summary;
    document.getElementById('courseModal').style.display = 'block';

    const applyBtn = document.getElementById('applyBtn');
    applyBtn.disabled = !canApply;
    if (!canApply) {
        applyBtn.innerText = 'Cannot Apply';
    } else {
        applyBtn.innerText = 'Apply';
    }

    applyBtn.onclick = function() {
        applyAction(courseId);
    };
}

function applyAction(courseId) {
    const studentId = document.getElementById('studentId').value;

    fetch('apply.php', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/x-www-form-urlencoded',
        },
        body: `course_id=${courseId}&student_id=${studentId}`
    })
    .then(response => response.text())
    .then(data => {
        Swal.fire({
            title: 'Application Status',
            text: data,
            icon: data.includes('successful') ? 'success' : 'error',
            confirmButtonText: 'OK'
        }).then(() => {
            if (data.includes('successful')) {
                // Refresh the page to update the list of applied courses
                window.location.reload();
            }
        });
    })
    .catch(error => console.error('Error:', error));
}

function closeModal() {
    document.getElementById('courseModal').style.display = 'none';
}

<!-- SweetAlert and JavaScript logout logic -->

function toggleDropdown() {
    var dropdown = document.getElementById('logout-dropdown');
    dropdown.style.display = dropdown.style.display === 'none' ? 'block' : 'none';
}

function confirmLogout(){
    Swal.fire({
        title: 'Are you sure?',
        text: "You will be logged out!",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Yes, logout!',
        cancelButtonText: 'Cancel'
    }).then((result) => {
        if (result.isConfirmed) {
            // Redirect to the user registration page after logout
            window.location.href ='../User_registration/user.php';  // Adjust this path to your actual user registration page
        }
    });
 
}
</script>
</body>
</html>