<?php
include '../database_connection/db_connection.php';
require 'vendor/autoload.php';

use PhpOffice\PhpSpreadsheet\IOFactory;

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_FILES['student_file'])) {
    $file = $_FILES['student_file']['tmp_name'];

    try {
        // Load the Excel file
        $spreadsheet = IOFactory::load($file);
        $sheet = $spreadsheet->getActiveSheet();
        $data = $sheet->toArray(null, true, true, false); // Convert to array

        echo "<h3>✅ Extracted Data from Excel:</h3>";

        foreach ($data as $index => $row) {
            if ($index === 0) continue; // Skip header row

            // Mapping columns correctly
            $mid = isset($row[1]) ? trim((string) $row[1]) : ""; // Ensure MID is a string
            $firstname = isset($row[2]) ? trim($row[2]) : "";
            $lastname = isset($row[3]) ? trim($row[3]) : "";
            $email = isset($row[4]) ? trim($row[4]) : "";
            $mobile = isset($row[5]) ? trim((string) $row[5]) : ""; // Store as string to avoid integer overflow
            $faculty = isset($row[6]) && $row[6] !== "" ? (string) trim($row[6]) : "Unknown"; // Ensure Faculty is a string
            $class = isset($row[7]) && $row[7] !== "" ? (string) trim($row[7]) : "Unknown";   // Ensure Class is a string

            // Debugging output to verify correct values
            echo "<pre>🔍 Debug Row $index:
            MID: '$mid', Name: '$firstname $lastname', Email: '$email', Mobile: '$mobile',
            Faculty: '$faculty', Class: '$class'</pre>";

            var_dump($faculty);
            var_dump($class);

            // Skip invalid rows
            if (empty($mid) || empty($firstname) || empty($email)) {
                echo "<b>⚠️ Skipping row $index due to missing required data.</b><br>";
                continue;
            }

            // Insert into database
            $stmt = $conn->prepare("INSERT INTO student_admin (mid, firstname, lastname, email, mobile_number, select_class, select_faculty) VALUES (?, ?, ?, ?, ?, ?, ?)");
            $stmt->bind_param('sssssss', $mid, $firstname, $lastname, $email, $mobile, $class, $faculty);

            if ($stmt->execute()) {
                echo "✅ <b>Row $index inserted successfully!</b><br>";
            } else {
                echo "❌ <b>Error inserting row $index:</b> " . $stmt->error . "<br>";
            }
        }

        echo "<br><h3>🎉 Bulk upload completed!</h3>";
    } catch (Exception $e) {
        echo "❌ Error uploading file: " . $e->getMessage();
    }

    $conn->close();
}
?>
