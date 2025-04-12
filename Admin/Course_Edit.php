<?php
     include '../database_connection/db_connection.php';


$course_id = isset($_GET['id']) ? intval($_GET['id']) : 0;

if ($course_id > 0) {
    
    $sql = "SELECT * FROM courses2 WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param('i', $course_id);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows == 1) {
        $course = $result->fetch_assoc();
    } else {
        die("Course not found");
    }

    $stmt->close();
} else {
    die("Course ID not found");
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Course</title>
    <link rel="stylesheet" href="add_course_form.css">
</head>
<body>

    <div class="header">
        <h2>Edit Course</h2>
    </div>

    <div class="container">
        <form id="edit-course-form" class="form-element" action="Update_course.php" method="post">
            
            <input type="hidden" name="id" value="<?php echo htmlspecialchars($course['id']); ?>">

            <div class="form-row">
                <label for="code">Code:</label>
                <input type="text" id="code" name="code" value="<?php echo htmlspecialchars($course['code']); ?>" required>
            </div>

            <div class="form-row">
                <label for="title">Title:</label>
                <input type="text" id="title" name="title" value="<?php echo htmlspecialchars($course['title']); ?>" required>
            </div>

            <div class="form-row">
                <label for="faculty">Faculty:</label>
                <select id="faculty" name="faculty" required>
                    <option value="">Select Faculty</option>
                    <option value="Arts" <?php echo ($course['faculty'] == 'Arts') ? 'selected' : ''; ?>>Arts</option>
                    <option value="Commerce" <?php echo ($course['faculty'] == 'Commerce') ? 'selected' : ''; ?>>Commerce</option>
                    <option value="Science" <?php echo ($course['faculty'] == 'Science') ? 'selected' : ''; ?>>Science</option>
                    <option value="Bca" <?php echo ($course['faculty'] == 'Bca') ? 'selected' : ''; ?>>Bca</option>
                    <option value="Bcs" <?php echo ($course['faculty'] == 'Bcs') ? 'selected' : ''; ?>>Bcs</option>
                </select>
            </div>

            <div class="form-row">
                
                <input type="text" id="visible" class="dropdown-input" placeholder="COURSES BELOW" readonly>
 
                    <div class="dropdown-menu">
                        <label><input type="checkbox" name="visible[]" value="Arts" 
                        <?php echo (in_array('Arts', explode(', ', $course['visible']))) ? 'checked' : ''; ?>>Arts</label>

                        <label><input type="checkbox" name="visible[]" value="Commerce" 
                        <?php echo (in_array('Commerce', explode(', ', $course['visible']))) ? 'checked' : ''; ?>>Commerce</label>

                        <label><input type="checkbox" name="visible[]" value="Science" 
                        <?php echo (in_array('Science', explode(', ', $course['visible']))) ? 'checked' : ''; ?>>Science</label>
 
                        <label><input type="checkbox" name="visible[]" value="BCS" 
                        <?php echo (in_array('BCS', explode(', ', $course['visible']))) ? 'checked' : ''; ?>>BCS</label>

                        <label><input type="checkbox" name="visible[]" value="BBA" 
                        <?php echo (in_array('BBA', explode(', ', $course['visible']))) ? 'checked' : ''; ?>>BBA</label>

                        <label><input type="checkbox" name="visible[]" value="BCA Science" 
                        <?php echo (in_array('BCA Science', explode(', ', $course['visible']))) ? 'checked' : ''; ?>>BCA Science</label>
                    </div>
            </div>


            <div class="form-row">
                <label for="group">Select Group:</label>

                        <select id="group" name="group"  required>
                               <option value="">Select Group</option>
                                <option value="9:00 AM TO 10:00 AM" <?php echo ($course['group']== '9:00 AM TO 10:00 AM') ? 'selected' : ''; ?>>9:00 AM TO 10:00 AM</option>
                                <option value="10:00 AM TO 11:00 AM" <?php echo ($course['group']== '10:00 AM TO 11:00 AM') ? 'selected' : ''; ?>>10:00 AM TO 11:00 AM</option>
                                <option value="11:00 AM TO 12:00 PM" <?php echo ($course['group']== '11:00 AM TO 12:00 PM') ? 'selected' : ''; ?>>11:00 AM TO 12:00 PM</option>
                                <option value="12:00 PM TO 1:00 PM" <?php echo ($course['group']== '12:00 PM TO 1:00 PM') ? 'selected' : ''; ?>>12:00 PM TO 1:00 PM</option>
                                <option value="10:30 AM TO 11:30 AM" <?php echo ($course['group']== '10:30 AM TO 11:30 AM') ? 'selected' : ''; ?>>10:30 AM TO 11:30 AM</option>
                                <option value="8:00 AM TO 9:00 AM" <?php echo ($course['group']== '8:00 AM TO 9:00 AM') ? 'selected' : ''; ?>>8:00 AM TO 9:00 AM</option>
                                
                        </select>
            </div>

            <div class="form-row">
                <label for="summary">Summary:</label>
                <textarea id="summary" name="summary" required><?php echo htmlspecialchars($course['summary']); ?></textarea>
            </div>


            <div class="form-row">
                <label for="Student limit">Student limit:</label>
                <input type="text" id="Student limit" name="studentlimit" value="<?php echo htmlspecialchars($course['studentlimit']); ?>" required>
            </div>

            <button type="submit">Update Course</button>
            <button type="button" onclick="CloseEdit()">Cancel</button>
        </form>
    </div>
    <script src="/Javascript/script.js"></script>
</body>

</html>


<?php $conn->close(); ?>