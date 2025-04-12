<?php
     include '../database_connection/db_connection.php';

$code = $_POST['code'];
$title = $_POST['title'];
$faculty = $_POST['faculty'];
$visible = $_POST['visible'];
$group = $_POST['group'];
$summary = $_POST['summary'];
$studentlimit = $_POST['studentlimit'];

$sql = "INSERT INTO courses (code, title, faculty, visible, group, summary, studentlimit)
       VALUES ('$code','$title','$faculty','$visible','$group','$summary','$studentlimit')";

if ($conn->query($sql) === TRUE) {
    $id = $conn->insert_id;
    $no = $conn->query("SELECT COUNT(*) AS count FROM courses2")->fetch_assoc()['count'];
    echo json_encode([
        'success' => true,
        'id' => $id,
        'no' => $no,
        'code' => $code,
        'title' => $title,
        'faculty' => $faculty,
        'visible' => $visible,
        'group' => $group,
        'summary' => $summary,
        'studentlimit' => $studentlimit
    ]);
} else {
    echo json_encode(['success' => false]);
}

$conn->close();
?>