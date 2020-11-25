<?php 
	if(isset($_GET['id']) && !empty($_GET['id']))
	{
			include 'dbcon.php';
			$idr=$_GET['id'];
			$sql5= "SELECT * FROM logs WHERE id='$idr'";
			$result = mysqli_query($db1,$sql5);
			while ($row = mysqli_fetch_assoc($result))
			{
				$id=$row['id'];
				$fn= $row['firstname'];
				$ln= $row['lastname'];
				$gn= $row['gender'];
				$cn=$row['country'];
			}
	}
	else
	{
		$fn='';
		$ln='';
		$gn='';
		$cn='';
	}
		
	
	?>
<html>
<head>
<title>REGISTRATION FORM</title> 
<script type="text/javascript">
	function form_validation()		
		{
			var firstname = document.forms["inputform"]["f_name"]; 
			var lastname = document.forms["inputform"]["l_name"]; 
			var gender=document.getElementsByName("gender");
			var country = document.forms["inputform"]["country"]; 
				
				
				
			if (firstname.value == "")                                 
			{
				window.alert("Please enter your first name!");
				firstname.focus();
				return false;
			}			
			if (lastname.value == "")                                 
			{
				window.alert("Please enter your last name!");
				lastname.focus();
				return false;
			}
			var i=0;
			var valid=false;
			while(!valid && i<gender.length)
			{
				if(gender[i].checked)
				{
					valid=true;
				}
				
				i++;
			}
			if(!valid)
			{
				alert("Please choose your gender!");
				return false;
			}
		
	
			

			 if (country.value== "select")                 
			{
				alert("Please select your Country!");
				country.focus();
				return false;
			}
			
		}
		</script>
		<style type="text/css">
		body{
		background-image:url('b2.jpg');
		background-color: #cccccc;
		background-repeat: no-repeat;
		background-size:cover;		}
		center{  
				color:white;
				box-sizing: border-box; 
				width: 100%; 
				border: 5px solid red;
				border-color:green;
				float: center; 
				align-content: center; 
				align-items: center; 
				} 
		</style>
	 </head>


    </head>
	
    <body>

	<center>
	<h1 style="color:green">REGISTRATION FORM</h1>
	<form name="inputform"  method="post" action="edit.php" onsubmit="return form_validation()">
	<input type='hidden' name='id' value='<?php echo $idr;?>'/> 
    <p><label>Firstname: <input type="text" name="f_name" value="<?php echo $fn; ?>" maxlength="20"  pattern="[A-Za-z]{3,20}"placeholder="ex:sakthi" required> </label></p>
    <p><label>Last Name: <input type="text" name="l_name" value="<?php echo $ln; ?>"  maxlength="20" pattern="[A-Za-z]{3,20}" placeholder="ex:sam"></label></p>
    <p><label>Gender:
    <input type="radio" name="gender" value="Male" <?php echo ($gn=='Male')?'checked':'' ?> >Male
    <input type="radio" name="gender" value="Female" <?php echo ($gn=='Female')?'checked':'' ?> >Female
	<input type="radio" name="gender" value="Others" <?php echo ($gn=='Others')?'checked':'' ?> >Others</label></p>
	<p><label>Country:
    <select name = "country"><option value="select">Select</option>
    <option value="india" <?php echo ($cn=='india')?'selected':'' ?>>India</option>
    <option value="australia" <?php echo ($cn=='australia')?'selected':'' ?>>Australia</option>
	<option value="pakistan" <?php echo ($cn=='pakistan')?'selected':'' ?>>Pakistan</option>
	<option value="westindies"  <?php echo ($cn=='westindies')?'selected':'' ?>>Westindies</option>
	<option value="bangladesh" <?php echo ($cn=='bangladesh')?'selected':'' ?>>Bangladesh</option></select>
		<p><input type="submit" name="submit" value="Submit">
		<input type="reset"  value="Reset"></p>
	</center>
	</form>
	<hr>
	<div id=tab></div>
	</body>
 </html>

