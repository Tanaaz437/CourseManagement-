<?php
include '../database_connection/db_connection.php';

// Get the teacher ID from the URL
$teacher_id = isset($_GET['id']) ? intval($_GET['id']) : 0;

if ($teacher_id > 0) {
    // Fetch the teacher's details based on the ID
    $sql = "SELECT * FROM teachers WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param('i', $teacher_id);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows == 1) {
        $teacher = $result->fetch_assoc();
    } else {
        die("Teacher not found");
    }

    $stmt->close();
} else {
    die("Teacher ID not found");
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Teacher</title>
    <link rel="stylesheet" href="add_teach_form.css">
</head>
<body>

    <div class="header">
        <h2>Edit Teacher</h2>
    </div>

    <div class="container">
        <form id="edit-teacher-form" class="form-element" action="Upadte_teacher.php" method="post">
            
            <input type="hidden" name="id" value="<?php echo htmlspecialchars($teacher['id']); ?>">

            <div class="form-row">
                <label for="first-name">First Name:</label>
                <input type="text" id="first-name" name="first_name" value="<?php echo htmlspecialchars($teacher['first_name']); ?>" required>
            </div>

            <div class="form-row">
                <label for="last-name">Last Name:</label>
                <input type="text" id="last-name" name="last_name" value="<?php echo htmlspecialchars($teacher['last_name']); ?>" required>
            </div>

            <div class="form-row">
                <label for="email">Email:</label>
                <input type="email" id="email" name="email" value="<?php echo htmlspecialchars($teacher['email']); ?>" required>
            </div>

            <div class="form-row">
                <label for="faculty">Faculty:</label>
                <select id="faculty" name="faculty" required>
                    <option value="">Select Faculty</option>
                    <option value="Arts" <?php echo ($teacher['faculty'] == 'Arts') ? 'selected' : ''; ?>>Arts</option>
                    <option value="Commerce" <?php echo ($teacher['faculty'] == 'Commerce') ? 'selected' : ''; ?>>Commerce</option>
                    <option value="Science" <?php echo ($teacher['faculty'] == 'Science') ? 'selected' : ''; ?>>Science</option>
                    <option value="Bca" <?php echo ($teacher['faculty'] == 'Bca') ? 'selected' : ''; ?>>Bca</option>
                    <option value="Bcs" <?php echo ($teacher['faculty'] == 'Bcs') ? 'selected' : ''; ?>>Bcs</option>
                </select>
            </div>

            <div class="form-row">
                <label for="department">Department:</label>
                <select id="department" name="department" required>
                    <option value="">Select Department</option>
                    <option value="Hindi" <?php echo ($teacher['department'] == 'Hindi') ? 'selected' : ''; ?>>Hindi</option>
                    <option value="Maths" <?php echo ($teacher['department'] == 'Maths') ? 'selected' : ''; ?>>Maths</option>
                    <option value="Science" <?php echo ($teacher['department'] == 'Science') ? 'selected' : ''; ?>>Science</option>
                    <option value="STATISTICS" <?php echo ($teacher['department'] == 'STATISTICS') ? 'selected' : ''; ?>>STATISTICS</option>
                    <option value="Computer Science" <?php echo ($teacher['department'] == 'Computer Science') ? 'selected' : ''; ?>>Computer Science</option>
                    <option value="Marathi" <?php echo ($teacher['department'] == 'Marathi') ? 'selected' : ''; ?>>Marathi</option>
                </select>
            </div>

            <div class="form-row">
                <label for="designation">Designation:</label>
                <input type="text" id="designation" name="designation" value="<?php echo htmlspecialchars($teacher['designation']);?>" required>
            </div>

            <div class="form-row">
                <label for="mid">MID:</label>
                <input type="text" id="mid" name="mid" value="<?php echo htmlspecialchars($teacher['mid']); ?>" required>
            </div>

           <!--  <div class="form-group">
                <button type="submit" class="btn">Update Teacher</button>
                <a href="student.php" class="btn">Cancel</a>
            </div> -->
         

            <button type="submit">Update Teacher</button>
           
            <a href="teacher.php" class="btn">Cancel</a>
        </form>
    </div>
    <script src="/Javascript/script.js"></script>
</body>
</html>

<?php $conn->close(); ?>
