<?php
session_start();
session_unset();
session_destroy();
header("Location: ../User_registration/user.php");
exit();
?>