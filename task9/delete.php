

<?php

error_reporting(0);
include 'connect.php';
$id = mysqli_real_escape_string($conn, $_POST['id']);

echo $id;
if(!empty($id)){
$sql = "DELETE from user  where id='$id'";

if(mysqli_query($conn, $sql)){

echo "<script>alert('Deleted Successfully')</script>";
} else {
    echo 'query error: '. mysqli_error($conn);
}
}
?>