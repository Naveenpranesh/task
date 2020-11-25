<?php
include 'dbcon.php';
$fname=mysqli_real_escape_string($db1,$_POST["f_name"]);
$lname= mysqli_real_escape_string($db1,$_POST["l_name"]);
$gender=mysqli_real_escape_string($db1,$_POST["gender"]);
$country =mysqli_real_escape_string($db1,$_POST["country"]);
/*function test_input($data) {
  $data = trim($data);
  $data = stripslashes($data);
  $data = htmlspecialchars($data);
  return $data;
}*/
if(isset($fname)&&!empty($fname)&&isset($lname)&&!empty($lname)&&isset($gender)&&!empty($gender)&&isset($country)&&!empty($country))
{
	$idc="SELECT id FROM logs WHERE firstname='$fname'&&lastname='$lname' ";
	$checkr=mysqli_query($db1,$idc);
	if(mysqli_num_rows($checkr)>0)
	{
		echo 'same record exists,please insert a new one...!';
		die();
	}
	
	$sql = "INSERT INTO logs (id,firstname,lastname,gender,country)
	VALUES ('','$fname','$lname','$gender','$country')";
	$res=mysqli_query($db1,$sql);
	if($sql)
	{
		echo '<strong>inserted to records...</strong>';
		return $fname;
	}
	else
	{
		echo 'record not inserted';
	}
}
else
{
	echo 'illegal access encountered';
}
?>