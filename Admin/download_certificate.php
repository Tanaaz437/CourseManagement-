<?php
require ('../libs/fpdf.php');
include '../database_connection/db_connection.php';
session_start(); // Start the session
$loggedInStudentId = intval($_SESSION['student_id']); // Ensure proper integer conversion

// Query to fetch only the approved courses for the logged-in student
$query = "
    SELECT sa.firstname, 
           sa.lastname, 
           sa.email, 
           c.title AS course_title, 
           sc.certificate_generated_time,
           sc.student_id, 
           sc.course_id 
    FROM stud_cour sc
    JOIN student_admin sa ON sc.student_id = sa.id
    JOIN courses2 c ON sc.course_id = c.id
    WHERE sc.certificate_approved = 'Yes'
    AND sc.student_id = $loggedInStudentId"; // Fetch only for the logged-in student

$result = $conn->query($query);

// Check if the student has any approved courses
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $studentName = $row['firstname'] . " " . $row['lastname'];
        $courseTitle = $row['course_title'];
        $courseId = $row['course_id']; // Ensure the correct course is selected

        // Ensure we are fetching the correct generated time for this course
        $certificateGeneratedTime = $row['certificate_generated_time'];

        if (!$certificateGeneratedTime) {
            // If no certificate was previously generated, store the current date
            $currentDate = date("d-m-Y");
            // Update the database for this specific student and course
            $updateQuery = "UPDATE stud_cour 
                            SET certificate_generated_time = NOW() 
                            WHERE student_id = $loggedInStudentId AND course_id = $courseId";
            $conn->query($updateQuery);
        } else {
            // Use the existing date from the database if already generated
            $currentDate = date("d-m-Y", strtotime($certificateGeneratedTime));
        }

        // Create certificate with FPDF
        $pdf = new FPDF('L', 'mm', 'A4');
        $pdf->AddPage();
        $pdf->Image('../images/Certificate.png', 0, 0, 297, 210);

        // Add student name
        $pdf->SetFont('Arial', 'B', 32);
        $pdf->SetXY(50, 90);
        $pdf->Cell(200, 10, $studentName, 0, 1, 'C');

        // Add course title
        $pdf->SetFont('Arial', 'I', 20);
        $pdf->SetXY(50, 120);
        $pdf->Cell(200, 10, "Course: $courseTitle", 0, 1, 'C');

        // Add date (certificate download date)
        $pdf->SetFont('Arial', 'I', 20);
        $pdf->SetXY(50, 150);
        $pdf->Cell(200, 10, "Date: $currentDate", 0, 1, 'C');

        // Ensure the certificates folder exists
        if (!is_dir('../certificates')) {
            mkdir('../certificates', 0777, true);
        }

        // Fix: Remove invalid characters from filenames
        $safeCourseTitle = preg_replace('/[^A-Za-z0-9_-]/', '_', $courseTitle);
        $fileName = "Certificate_" . $row['firstname'] . "_" . $row['lastname'] . "_" . $safeCourseTitle . ".pdf";
        $filePath = "../certificates/" . $fileName;

        // Save the generated PDF
        $pdf->Output('F', $filePath); // Save PDF to the server

        // Display download link
    
        echo "<p style='font-size:20px;font-weight:bold;'>
        <a href='../certificates/" . $fileName . "' style='font-size:22px;text-decoration:none;color:blue;'>
        Download your certificate for $courseTitle
        </a><br>
        </p>";
    }
} else {
    echo "No approved certificate found.";
}

$conn->close();
?>
