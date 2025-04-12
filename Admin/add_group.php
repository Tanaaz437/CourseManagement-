<?php
include '../database_connection/db_connection.php';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Group</title>
    <link rel="stylesheet" href="grooup.css">
</head>
<body class="add-group-page">
<form action="process_add_group.php" method="POST">
    <div id="main-content">
        <div class="breadcrumb">
            <ul>
                <li><i class="fa-solid fa-bars"></i> Add Group</li>
            </ul>
        </div>  
        <div class="main-container">
            <div class="Group-Name-box">
                <input type="text" name="name" id="Group-name" placeholder="Name*" required>
                <div class="btn">
                    <button type="submit" id="group-btn">ADD</button>
                    <button type="button" id="group-cancel-btn" onclick="Close()">Close</button>
                </div>
            </div>
        </div>
    </div>
</form>
<script src="/Javascript/script.js"></script>
</body>
</html>
<?php
$conn->close();
?>
