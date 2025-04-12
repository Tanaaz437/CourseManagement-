<?php
include '../database_connection/db_connection.php';

// Fetch teacher names from the database
$query = "SELECT first_name, last_name FROM teachers";
 // Adjust table and column names as needed
$result = $conn->query($query);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Allocate Teacher</title>
    <link rel="stylesheet" href="add_course_form.css">
</head>
<body>
    <div class="header">
        <h2>Allocate Teacher for Courses</h2>
    </div>

    <div class="container">
        <form id="add-course-form" class="form-element" action="process_allocation.php" method="post">
            <div class="form-row">
                <label for="allocation">Allocation:</label>
                <input type="text" id="allocation" name="allocation" required>
            </div>

            <div class="form-row">
                <label for="select_teacher">Select Teacher:</label>
                <select id="select_teacher" name="select_teacher" required>
                    <option value="">Select Teacher</option>
                    <?php
                    // Generate <option> elements for each teacher
                    while ($row = $result->fetch_assoc()) {
                        $fullName = htmlspecialchars($row['first_name'] . ' ' . $row['last_name']);
                        echo '<option value="' . $fullName . '">' . $fullName . '</option>';
                    }
                    ?>
                </select>
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