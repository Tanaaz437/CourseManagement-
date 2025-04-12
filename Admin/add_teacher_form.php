<?php
include '../database_connection/db_connection.php';
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Teacher</title>
    <link rel="stylesheet" href="add_teach_form.css">
</head>
<body>
     
        <div class="header">
       <h2>ADD TEACHER</h2>
        </div>
    
    

    <div class="container">
    
        <form  id="add-teacher-form" class="form-element" class="formm"action="process_add_teacher.php" method="post">
        
        <div class="form-row">
                <label for="first-name">First Name:</label>
                <input type="text" id="first-name" name="first_name" required>
        </div>

        <div class="form-row">
                <label for="last-name">Last Name:</label>
                <input type="text" id="last-name" name="last_name" required>
        </div>

        <div class="form-row">
                <label for="email">Email:</label>
                <input type="email" id="email" name="email" required>
        </div>

        <div class="form-row">
                <label for="faculty">Faculty:</label>

                        <select id="faculty" name="faculty"  required>
                               <option value="">Select Faculty</option>
                                <option>Arts</option>
                                <option>Commerce</option>
                                <option>Science</option>
                                <option>BCS</option>
                                <option>BBA</option>
                                <option>BCA Science</option>

                        </select>
               <!--  <input type="text" id="faculty" name="faculty" required> -->
        </div>

        <div class="form-row">
                <label for="department">Department:</label>
                <select id="department" name="department" required>
                        <option value="">Select Department</option>
                                <option>BCA(Science)</option>
                                <option>BBA(CA)</option>
                                <option>BCOM</option>
                                <option>MCOM</option>
                                <option>BBA</option>
                                <option>Urdu </option>
                                <option>English</option>
                                <option>Arabic</option>
                                <option>MAths</option>
                                <option>Statistics</option>
                                <option>Computer Science</option>
                                <option>Hindi</option>
                                <option>Marathi</option>
                                <option>Physics</option>
                                <option>Botany</option>
                                <option>Zoology</option>

                        </select>
            <!--     <input type="text" id="department" name="department" required> -->
        </div>

        <div class="form-row">
                <label for="designation">Designation:</label>
                <input type="text" id="designation" name="designation" required>
        </div>

        <div class="form-row">
                <label for="mid">MID:</label>
                <input type="text" id="mid" name="mid" required>
        </div>

            <button type="submit">Submit</button>
            <button type="button" onclick="TeacherClose()">Cancel</button>
            
        </form>
    </div>
    <script src="/Javascript/script.js"></script>
</body>
</html>

<?php
$conn->close();
?>



