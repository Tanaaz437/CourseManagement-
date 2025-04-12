<?php
include '../database_connection/db_connection.php';

$firstname =$_POST['firstname'];
$lastname=$_POST['lastname'];
$email=$_POST['email'];
$mobile_number=$_POST['mobile_number'];
$select_faculty=$_POST['select_faculty'];
$select_class=$_POST['select_class'];
$mid=$_POST['mid'];


$sql="Insert into student_admin (firstname,lastname,email,mobile_number,select_faculty,select_class,mid) Values('$firstname','$lastname','$email','$mobile_number','$select_faculty','$select_class','$mid')";
if($conn->query($sql)==true){
          echo 'inserted successfully';
          header('location:student.php');


}else{
          echo "Error: " . $sql . "<br>" . $conn->error;
}
$conn->close();
?>