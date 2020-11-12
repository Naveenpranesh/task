

<?php

error_reporting(0);
include 'connect.php';
$id = mysqli_real_escape_string($conn, $_POST['id']);
$email = mysqli_real_escape_string($conn, $_POST['email']);
$name = mysqli_real_escape_string($conn, $_POST['name']);
$dob = mysqli_real_escape_string($conn, $_POST['dob']);
$age = mysqli_real_escape_string($conn, $_POST['age']);
$gender = mysqli_real_escape_string($conn, $_POST['gender']);
$course = mysqli_real_escape_string($conn, $_POST['course']);
$address=mysqli_real_escape_string($conn, $_POST['address']);

if(!empty($email)&&!empty($name)&&!empty($dob)&&!empty($age)&&!empty($gender)&&!empty($course)&&!empty($address)&&!empty($id)){
$sql = "UPDATE  user SET name= '$name',email='$email',dob='$dob',age='$age',gender='$gender',course='$course',address='$address' where id='$id'";

if(mysqli_query($conn, $sql)){

echo "<script>alert('Updated Successfully')</script>";
} else {
    echo 'query error: '. mysqli_error($conn);
}
}
?>