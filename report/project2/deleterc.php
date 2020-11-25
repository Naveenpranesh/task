<?php
include 'dbcon.php';
include 'sakthif1.html';
$idr=$_GET['id'];
$sql3="DELETE FROM logs WHERE id='$idr'";
$dl=mysqli_query($db1,$sql3);
if($dl)
{
	echo "record deleted";
	//include 'table.php';
	echo '<table border="2" cellspacing="2" cellpadding="2" align="center" style="color:white"> 
	<tr> 
	<td><font face="Arial">Id</font></td> 
	<td><font face="Arial">FirstName</font></td> 
	<td><font face="Arial">LastName</font></td> 
	<td><font face="Arial">Gender</font></td> 
	<td><font face="Arial">Country</font></td>
	<td><font face="Arial">ACTION</font></td>			
	</tr>';
	$sql1="SELECT * FROM logs";
	$resultset=mysqli_query($db1,$sql1);
	$r_count=mysqli_num_rows($resultset);
		if($r_count>0)
		{	
			while($row=mysqli_fetch_assoc($resultset)) 
			{
				$field1=$row["id"];
				$field2=$row["firstname"];
				$field3=$row["lastname"];
				$field4=$row["gender"];
				$field5=$row["country"]; 
				echo '<tr bordercolor="green"> 
                <td>'.$field1.'</td> 
				<td>'.$field2.'</td> 
                <td>'.$field3.'</td> 
                <td>'.$field4.'</td> 
				<td>'.$field5.'</td>
				<td><button><a href=sakthif1.php?id=';
				echo $field1.'>edit</a></button></td>
				<td><button><a href=deleterc.php?id=';
				echo $field1.'>delete</a></button></td>
				</tr>';
			}
		}
		else
		{
			echo 'no records found';
		}
	
}
else
{
	echo 'error while deleting';
}
?>