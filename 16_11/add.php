<?php

error_reporting(0);
include 'connect.php';


$name = mysqli_real_escape_string($conn, $_POST['name']);
$score = mysqli_real_escape_string($conn, $_POST['score']);
$array_index = mysqli_real_escape_string($conn, $_POST['array_index']);


if($name!=''&&$score!=''&&$array_index!=''){

            $sql = "INSERT INTO array_storage(name,score,array_index) VALUES('$name','$score','$array_index')";

            if(mysqli_query($conn, $sql)){

            
                }
                 else {
                  echo "<script>alert('query error:' ". mysqli_error($conn).")</script>";
                    }
                 } 


?>