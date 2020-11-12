<?php
error_reporting(0);
include "connect.php";

	echo '<table border="2" class="table table-bordered table-hover table-sm" align="center" cellspacing="2" cellpadding="2"> 
	<tr> 
	<td><font face="Arial">Id</font></td> 
	<td><font face="Arial">Name</font></td> 
	<td><font face="Arial">Email</font></td> 
	<td><font face="Arial">Gender</font></td> 
	<td><font face="Arial">Age</font></td>
    <td><font face="Arial">DOB</font></td>
    
    <td><font face="Arial">ADDRESS</font></td> 
    <td><font face="Arial">CREATED DATE</font></td> 
    
    <td><font face="Arial">EDIT</font></td> 
	<td><font face="Arial">DELETE</font></td> 
	
	</tr>';
    $sql1 = 'SELECT * FROM user';
	$resultset=mysqli_query($conn,$sql1);
	$r_count=mysqli_num_rows($resultset);
		if($r_count>0)
		{	
			while($row=mysqli_fetch_assoc($resultset)) 
			{
				$field1=$row["id"];
                $field2=$row["name"];
                $field3=$row["email"];
                $field4=$row["gender"];
                $field5=$row["age"];
                $field6=$row["dob"];
                $field7=$row["address"]; 
                $field8=$row["createdDate"];
                
             
				
				echo '<tr bordercolor="green"> 
                <td>'.$field1.'</td> 
				<td>'.$field2.'</td> 
                <td>'.$field3.'</td> 
                <td>'.$field4.'</td> 
                <td>'.$field5.'</td>
                <td>'.$field6.'</td> 
				<td>'.$field7.'</td> 
				<td>'.$field8.'</td> 
				
			

				<td><button class="btn" id="toedit"><a class="alert alert-dark" href=getbyid.php?id=';
				echo $field1.'>edit</a></button></td>
				<td><button class="btn" id="todelete"><a class="alert alert-dark" href=getbyiddelete.php?id=';
				echo $field1.'>delete</a></button></td>
				</tr>';


			}
		}
		else
		{

			echo 'no records found';
		}
?>