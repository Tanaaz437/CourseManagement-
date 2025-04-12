<?php
include '../database_connection/db_connection.php';
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Course</title>
    <link rel="stylesheet" href="add_course_form.css">
</head>
<body>
    <div class="header">
        <h2>Add Courses</h2>
    </div>

    <div class="container">
        <form id="add-course-form" class="form-element" action="process_add_course.php" method="post">
            <div class="form-row">
                <label for="code">Code:</label>
                <input type="text" id="code" name="code" required>
            </div>

            <div class="form-row">
                <label for="title">Title:</label>
                <input type="text" id="title" name="title" required>
            </div>

            <div class="form-row">
                <label for="faculty">Faculty:</label>
                <select id="faculty" name="faculty" required>
                    <option value="">Select Faculty</option>
                    <option>Arts</option>
                    <option>Commerce</option>
                    <option>Science</option>
                    <option>BCS</option>
                    <option>BBA</option>
                    <option>BCA Science</option>
                </select>
            </div>

            <div class="form-row">
                <!-- <label for="visible">To be Visible below Faculty:</label> -->
                <div class="dropdown">
                    <input type="text" id="visible" class="dropdown-input" placeholder=" COURSES BELOW " readonly>
                    <div class="dropdown-menu">
                        <label><input type="checkbox" name="visible[]" value="Arts">Arts</label>
                        <label><input type="checkbox" name="visible[]" value="Commerce">Commerce</label>
                        <label><input type="checkbox" name="visible[]" value="Science">Science</label>
                        <label><input type="checkbox" name="visible[]" value="BCS">BCS</label>
                        <label><input type="checkbox" name="visible[]" value="BBA">BBA</label>
                        <label><input type="checkbox" name="visible[]" value="BCA Science">BCA Science</label>
                    </div>
                </div>
            </div>

            <div class="form-row">
                <label for="group">Select Group:</label>
                <select id="group" name="group" required>
                    <option value="">Select Group</option>
                    <option>9:00 AM TO 10:00 AM</option>
                    <option>10:00 AM TO 11:00 AM</option>
                    <option>11:00 AM TO 12:00 PM</option>
                    <option>12:00 PM TO 1:00 PM</option>
                    <option>10:30 AM TO 11:30 AM</option>
                    <option>8:00 AM TO 9:00 AM</option>
                </select>
            </div>

            <div class="form-row">
                <label for="summary">Summary:</label>
                <textarea id="summary" name="summary" required></textarea>
            </div>

            <div class="form-row">
                <label for="studentlimit">Student limit:</label>
                <input type="text" id="studentlimit" name="studentlimit" required>
            </div>

            <button type="submit">Submit</button>
            <button type="button" onclick="CloseCOurse()">Cancel</button>
        </form>
    </div>
    <script src="/Javascript/script.js"></script>
</body>
</html>

<?php
$conn->close();
?>