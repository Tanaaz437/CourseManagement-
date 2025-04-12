<?php
include '../database_connection/db_connection.php';

// Check if group ID is passed
if (isset($_GET['id'])) {
    $id = $_GET['id'];

    // Fetch group data from the database
    $stmt = $conn->prepare("SELECT * FROM groupslots WHERE id = ?");
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $result = $stmt->get_result();
    $group = $result->fetch_assoc();

    if (!$group) {
        echo "Group not found.";
        exit();
    }

    $stmt->close();
} else {
    // Redirect if no ID is provided
    header('Location: group.php');
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Group</title>
    <link rel="stylesheet" href="grooup.css">
</head>
<body class="edit_group">
<form action="process_edit_group.php" method="POST">
    <input type="hidden" name="id" value="<?php echo $group['id']; ?>" />
    <div id="main-content">
        <div class="breadcrumb">
            <ul>
                <li><i class="fa-solid fa-bars"></i> Edit Group</li>
            </ul>
        </div>  
        <div class="main-container">
            <div class="Group-Name-box">
                <input type="text" name="name" id="Group-name" placeholder="Name*" value="<?php echo htmlspecialchars($group['name']); ?>" required>
                <div class="btn">
                    <button type="submit" id="group-btn">Update</button>
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
