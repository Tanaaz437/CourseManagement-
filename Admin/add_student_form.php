<!DOCTYPE html>
<html lang="en">
<head>
          <meta charset="UTF-8">
          <meta name="viewport" content="width=device-width, initial-scale=1.0">
          <title> Add Student</title>
          <link rel="stylesheet" href="add_teach_form.css">
</head>
<body>
        <div class="header">
        
        <h2>ADD STUDENT</h2>
        </div>
<div class="container">
        
    
    <form  id="add-student-form" class="form-element" class="formm"action="process_add_student.php" method="post">
    <div class="form-row">
            <label for="firstname">First Name:</label>
            <input type="text" id="firstname" name="firstname" required>
    </div>

    <div class="form-row">
            <label for="lastname">Last Name:</label>
            <input type="text" id="lastname" name="lastname" required>
    </div>

    <div class="form-row">
            <label for="email">Email:</label>
            <input type="email" id="email" name="email" required>
    </div>

    <div class="form-row">
            <label for="mobile_number">Mobile:</label>
            <input type="number" id="mobile_number" name="mobile_number" required>
    </div>



    <div class="form-row">
            <label for="select_faculty">Faculty:</label>

                    <select id="select_faculty" name="select_faculty"  required>
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
            <label for="select_class">Class:</label>
            <select id="select_class" name="select_class" required>
                    <option value="">Select Class</option>
                            <option>UG-FY</option>
                            <option>UG-SY</option>
                            <option>UG-TY</option>
                            <option>PG-FY</option>
                            <option>PG-SY</option>
                            <option>PG-TY </option>

                    </select>
       
    </div>

    

    <div class="form-row">
            <label for="mid">MID:</label>
            <input type="text" id="mid" name="mid" required>
    </div>

        <button type="submit">Submit</button>
        
        <button type="button" onclick="window.location.href='/Admin/student.php';">Cancel</button>

    </form>
</div>
<script src="/Javascript/script.js"></script>
</body>
</html>