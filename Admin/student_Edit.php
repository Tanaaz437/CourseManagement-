<?php
include '../database_connection/db_connection.php';

// Get the MID from the URL
$mid = isset($_GET['mid']) ? $_GET['mid'] : null;

if ($mid !== null) {
    // Fetch the student's ID based on MID
    $sql = "SELECT id FROM student_admin WHERE mid = ?";
    $stmt = $conn->prepare($sql);
    if (!$stmt) {
        die("SQL prepare failed: " . $conn->error);
    }
    $stmt->bind_param('s', $mid); // Use 's' since MID is a string
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows == 1) {
        $student = $result->fetch_assoc();
        $student_id = $student['id']; // Get the ID for updating
    } else {
        die("Student not found with this MID.");
    }

    $stmt->close();

    // Now fetch the full student details using the ID
    $sql = "SELECT * FROM student_admin WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param('i', $student_id);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows == 1) {
        $student = $result->fetch_assoc();
    } else {
        die("Student not found with ID.");
    }

    $stmt->close();
} else {
    die("MID not found in the URL.");
}

// Continue with the form if student data was found
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Student</title>
    <link rel="stylesheet" href="student_Edit.css">
</head>
<body>

<div class="header">
    <h2>Edit Student</h2>
</div>

<div class="container">
    <form id="edit-student-form" class="form" action="Update_student.php" method="POST">
        <input type="hidden" name="student_id" value="<?php echo htmlspecialchars($student_id); ?>">

        <div class="form-group">
            <label for="mid">MID:</label>
            <input type="text" id="mid" name="mid" value="<?php echo htmlspecialchars($student['mid']); ?>" required>
        </div>

        <div class="form-group">
            <label for="firstname">First Name:</label>
            <input type="text" id="firstname" name="firstname" value="<?php echo htmlspecialchars($student['firstname']); ?>" required>
        </div>

        <div class="form-group">
            <label for="lastname">Last Name:</label>
            <input type="text" id="lastname" name="lastname" value="<?php echo htmlspecialchars($student['lastname']); ?>" required>
        </div>

        <div class="form-group">
            <label for="email">Email:</label>
            <input type="email" id="email" name="email" value="<?php echo htmlspecialchars($student['email']); ?>" required>
        </div>

        <div class="form-group">
            <label for="mobile_number">Mobile Number:</label>
            <input type="text" id="mobile_number" name="mobile_number" value="<?php echo htmlspecialchars($student['mobile_number']); ?>" required>
        </div>

        <div class="form-group">
            <label for="select_class">Class:</label>
            <select id="select_class" name="select_class" required>
                <option value="">Select Class</option>
                <option value="UG-F.Y" <?php echo($student['select_class']=='UG-F.Y')? 'selected':'';?>>UG-F.Y</option>
                <option value="UG-S.Y" <?php echo($student['select_class']=='UG-S.Y')? 'selected':''?>>UG-S.Y</option>
                <option value="UG-T.Y" <?php echo($student['select_class']=='UG-T.Y')? 'selected':''?>>UG-T.Y</option>
                <option value="PG-F.Y" <?php echo($student['select_class']=='PG-F.Y') ? 'selected':''?>>PG-F.Y</option>
                <option value="PG-S.Y" <?php echo($student['select_class']=='PG-S.Y')  ? 'selected':'' ?>>PG-S.Y</option>
                <option value="PG-T.Y" <?php echo($student['select_class']=='PG-T.Y') ? 'selected':'' ?>>PG-T.Y</option>
            </select>
        </div>

        <div class="form-group">
            <label for="select_faculty">Faculty:</label>
            <select id="select_faculty" name="select_faculty" required>
                <option value="">Select Faculty</option>
                <option value="ARTS" <?php echo ($student['select_faculty'] == 'ARTS') ? 'selected' : ''; ?>>ARTS</option>
                <option value="COMMERCE" <?php echo ($student['select_faculty'] == 'COMMERCE') ? 'selected' : ''; ?>>COMMERCE</option>
                <option value="Science" <?php echo ($student['select_faculty'] == 'Science') ? 'selected' : ''; ?>>Science</option>
                <option value="BCS" <?php echo ($student['select_faculty'] == 'BCS') ? 'selected' : ''; ?>>BCS</option>
                <option value="BBA" <?php echo ($student['select_faculty'] == 'BBA') ? 'selected' : ''; ?>>BBA</option>
                <option value="BCA SCIENCE" <?php echo ($student['select_faculty'] == 'BCA SCIENCE') ? 'selected' : ''; ?>>BCA SCIENCE</option>
            </select>
        </div>

        <button type="submit" class="btn">Update</button>
        <a href="student.php">Cancel</a>
    </form>
</div>

</body>
</html>
