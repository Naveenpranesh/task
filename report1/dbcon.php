<?php
$servername="localhost";
$username="root";
$password="";
$database="sakthi";
$db1=mysqli_connect($servername,$username,$password,$database);
if(!$db1)
{
	echo 'error in database connectivity';
	die();
	
}
?>