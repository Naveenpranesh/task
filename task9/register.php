<?php

error_reporting(0);
include 'connect.php';

$email = mysqli_real_escape_string($conn, $_POST['email']);
$name = mysqli_real_escape_string($conn, $_POST['name']);
$dob = mysqli_real_escape_string($conn, $_POST['dob']);
$age = mysqli_real_escape_string($conn, $_POST['age']);
$gender = mysqli_real_escape_string($conn, $_POST['gender']);
$course = mysqli_real_escape_string($conn, $_POST['course']);
$address=mysqli_real_escape_string($conn, $_POST['address']);

if(!empty($email)&&!empty($name)&&!empty($dob)&&!empty($age)&&!empty($gender)&&!empty($course)&&!empty($address)){
$sql = "INSERT INTO user(name,email,dob,age,gender,course,address) VALUES('$name','$email','$dob','$age','$gender','$course','$address')";

if(mysqli_query($conn, $sql)){

echo "<script>alert('Inserted Successfully')</script>";
} else {
    echo 'query error: '. mysqli_error($conn);
}
}
?>