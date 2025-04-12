<?php
// Set the headers to force a download
header('Content-Type: text/csv');
header('Content-Disposition: attachment;filename=student_template.csv');

// Open output stream
$output = fopen('php://output', 'w');

// Add the CSV columns as the template (e.g., for student details)
fputcsv($output, ['mid', 'firstname', 'lastname', 'email', 'mobile_number', 'select_class', 'select_faculty']);

// Close the stream
fclose($output);
?>
