<?php
require '../vendor/autoload.php'; 

use PhpOffice\PhpSpreadsheet\IOFactory;

$uploadDir = 'uploads/';

// Check if the uploads directory exists
if (!is_dir($uploadDir)) {
    mkdir($uploadDir, 0777, true); // Create the directory if it doesn't exist
}

// Check if a file was uploaded
if (isset($_FILES['file'])) {
    $file = $_FILES['file'];

    // Check if file was uploaded without errors
    if ($file['error'] === UPLOAD_ERR_OK) {
        $fileExtension = strtolower(pathinfo($file['name'], PATHINFO_EXTENSION));
        if (!in_array($fileExtension, ['xls', 'xlsx', 'csv'])) {
            die("Invalid file type. Only Excel and CSV files are allowed.");
        }

        $uploadFile = $uploadDir . basename($file['name']);

        if (move_uploaded_file($file['tmp_name'], $uploadFile)) {
            echo "File successfully uploaded.";

            // Handle file based on type
            if ($fileExtension === 'csv') {
                if (($handle = fopen($uploadFile, 'r')) !== false) {
                    $data = [];
                    $headers = fgetcsv($handle); // Read the first row as headers
                    while (($row = fgetcsv($handle)) !== false) {
                        $row = array_map('trim', $row);
                        $data[] = $row; // Add each row to the data array
                    }
                    fclose($handle);
                } else {
                    die("Failed to open CSV file.");
                }
            } else {
                $spreadsheet = IOFactory::load($uploadFile);
                $sheet = $spreadsheet->getActiveSheet();
                $data = $sheet->toArray();
                $headers = array_shift($data); // Assuming the first row contains column headers
            }

            $conn = new mysqli('localhost', 'root', '', 'admin');
            if ($conn->connect_error) {
                die("Connection failed: " . $conn->connect_error);
            }

            $stmt = $conn->prepare("INSERT INTO student_admin (firstname, lastname, email, mobile_number, select_faculty, select_class, mid) VALUES (?, ?, ?, ?, ?, ?, ?)");

            if ($stmt === false) {
                die("Prepare failed: " . $conn->error);
            }

            foreach ($data as $row) {
                $firstname = trim($row[0]);
                $lastname = trim($row[1]);
                $email = trim($row[2]);
                $mobile_number = trim($row[3]);
                $select_faculty = trim($row[4]);
                $select_class = trim($row[5]);
                $mid = trim($row[6]);

                // Skip invalid or zero values for mobile_number and mid
                if ($mobile_number == 0 || $mid == 0) {
                    echo "Invalid data for mobile_number ($mobile_number) or mid ($mid). Skipping this row.<br>";
                    continue; // Skip this row
                }

                // Check if the mobile_number and mid already exist in the database
                $checkQuery = $conn->prepare("SELECT id FROM student_admin WHERE mobile_number = ? OR mid = ?");
                $checkQuery->bind_param("ii", $mobile_number, $mid);
                $checkQuery->execute();
                $checkQuery->store_result();

                if ($checkQuery->num_rows > 0) {
                    // Entry already exists, so we skip it
                    echo "Record with mobile_number: $mobile_number or mid: $mid already exists. Skipping insert.<br>";
                } else {
                    // Proceed with inserting the new row
                    echo "Inserting record with mobile_number: $mobile_number and mid: $mid<br>";

                    $mobile_number = (int)$mobile_number;
                    $mid = (int)$mid;

                    $stmt->bind_param("ssssiii", $firstname, $lastname, $email, $mobile_number, $select_faculty, $select_class, $mid);

                    if (!$stmt->execute()) {
                        echo "Error inserting row: " . $stmt->error . "<br>";
                    }
                }

                $checkQuery->close(); // Close the check query after each iteration
            }

            $stmt->close();
            $conn->close();
            echo "Data successfully inserted into database.";
            header('location:student.php');
        } else {
            echo "Failed to move uploaded file.";
        }
    } else {
        echo "File upload error: " . $file['error'];
    }
} else {
    echo "No file uploaded.";
}
?>
