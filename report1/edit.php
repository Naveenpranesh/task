<?php

$id=$_POST['id'];
$f1=$_POST['f_name'];
$f2=$_POST['l_name'];
$f3=$_POST['gender'];
$f4=$_POST['country'];
$sql7="UPDATE logs SET firstname='$f1',lastname='$f2',gender='$f3',country='$f4' WHERE id='$id' ";
$res=mysqli_query($db1,$sql7);
if($res)
{
	echo 'edited successfully';
	
}
else
{
	echo 'edit failed';
}
?>