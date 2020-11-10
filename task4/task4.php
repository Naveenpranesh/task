<?php
error_reporting(0);
	include 'connect.php';
    $email = $name = $password = $edit_email =$edit_password = $new_password = $new_email = $new_username= '';
    $errors = array('email' => '', 'name' => '', 'password' => '','edit_email' => '', 'edit_password' => '','new_email' => '', 'new_username' => '', 'new_password' => '');
    
   

    if(isset($_POST['submit'])){
        if(empty($_POST['email'])){
			$errors['email'] = 'An email is required';
		} else{
			$email = $_POST['email'];
			if(!filter_var($email, FILTER_VALIDATE_EMAIL)){
				$errors['email'] = 'Email must be a valid email address';
			}
        }
        
        if(empty($_POST['name'])){
			$errors['name'] = 'An UserName is required';
		} else{
			$name = $_POST['name'];
			if(!preg_match('/^[a-zA-Z\s]+$/', $name)){
				$errors['name'] = 'Name must be letters and spaces only';
			}
        }
        if(empty($_POST['password'])){
			$errors['password'] = 'Password is Required';
        }
       
        

        if(array_filter($errors)){
			echo 'errors in form';
		} else {
			// escape sql chars
			$email = mysqli_real_escape_string($conn, $_POST['email']);
			$name = mysqli_real_escape_string($conn, $_POST['name']);
            $password = md5(mysqli_real_escape_string($conn, $_POST['password']));
           // $createdDate=date("Y/m/d");

			// create sql
			$sql = "INSERT INTO test(userName,email,password) VALUES('$name','$email','$password')";

			// save to db and check
			if(mysqli_query($conn, $sql)){
				// success
			echo 'Inserted Sucessfully';
			} else {
				echo 'query error: '. mysqli_error($conn);
			}
			
		}
    }
    if(isset($_POST['getAll'])){
        $sql = 'SELECT id,userName, email,createdDate FROM test ORDER BY createdDate';

        
        $result = mysqli_query($conn, $sql);
 
        $test = mysqli_fetch_all($result, MYSQLI_ASSOC);

        mysqli_free_result($test);

        mysqli_close($conn);
    }
    
    if(isset($_POST['edit'])){

        if(empty($_POST['edit_email'])){
			$errors['edit_email'] = 'An email is required';
		} else{
			$edit_email = $_POST['edit_email'];
			if(!filter_var($edit_email, FILTER_VALIDATE_EMAIL)){
				$errors['edit_email'] = 'Email must be a valid email address';
			}
        }
        
      
        if(empty($_POST['edit_password'])){
			$errors['edit_password'] = 'Password is Required';
		} else{
			$edit_password = $_POST['edit_password'];
		
        }

        if(empty($_POST['new_email'])){
			$errors['new_email'] = 'An email is required';
		} else{
			$new_email = $_POST['new_email'];
			if(!filter_var($new_email, FILTER_VALIDATE_EMAIL)){
				$errors['new_email'] = 'Email must be a valid email address';
			}
        }
        
        if(empty($_POST['new_username'])){
			$errors['new_username'] = 'An UserName is required';
		} else{
			$new_username = $_POST['new_username'];
			if(!preg_match('/^[a-zA-Z\s]+$/', $new_username)){
				$errors['new_username'] = 'Name must be letters and spaces only';
			}
        }


        if(empty($_POST['new_password'])){
			$errors['new_password'] = 'Password is Required';
		} else{
			$new_password = $_POST['new_password'];
			
        }
        

        if(array_filter($errors)){
			echo 'errors in form';
		} else {
        $edit_email= mysqli_real_escape_string($conn,$_POST['edit_email']);
        $edit_password= md5(mysqli_real_escape_string($conn,$_POST['edit_password']));

        $new_email= mysqli_real_escape_string($conn,$_POST['new_email']);
        $new_password= md5(mysqli_real_escape_string($conn,$_POST['new_password']));
        $new_username= mysqli_real_escape_string($conn,$_POST['new_username']);


       
        $sql = "UPDATE test SET userName = '$new_username' , email= '$new_email' ,password='$new_password' WHERE test.email='$edit_email' AND test.password ='$edit_password'";
        

        // get the result set (set of rows)
        
    
        // free the $result from memory (good practise)
      

        if(mysqli_query($conn, $sql)){
            // success
        echo 'Updated Sucessfully';

       // mysqli_free_result($edited);
        } else {
            echo 'query error: '. mysqli_error($conn);
        }
        }
    }

	if(isset($_POST['delete'])){

		$email_to_delete = mysqli_real_escape_string($conn, $_POST['email_to_delete']);

		$sql = "DELETE FROM test WHERE test.email = '$email_to_delete'";

		if(mysqli_query($conn, $sql)){
            echo 'Deleted Successfully';	//header('Location: index.php');
		} else {
			echo 'query error: '. mysqli_error($conn);
		}

	}

	
	if(isset($_POST['getById'])){
		
	
		$id_to_get = mysqli_real_escape_string($conn, $_POST['id_to_get']);

	
		$sql = "SELECT userName,email,createdDate FROM test WHERE id = $id_to_get";

		
		$result = mysqli_query($conn, $sql);

		$ret_data = mysqli_fetch_assoc($result);

		mysqli_free_result($result);
		mysqli_close($conn);

	}
?>


<!DOCTYPE html>
<html>
    <head>
    <style>
    table, th, td {
        border: 1px solid black;
            }
        </style>
        <h1>SERVER INFORMATIONS</h1>
        <?php  include 'connect.php'; if(!$conn){echo 'Connection error: '. mysqli_connect_error();} else{?>
        <h5>CLIENT LIBRARY VERSION IS: <?php  printf(mysqli_get_client_version()); ?> </h5>
        <h5>SERVER VERSION IS: <?php  printf($conn->server_info); ?> </h5>
        <h5>SERVER STATUS: <?php echo "CONNECTED";?></h5>
        <h5>HOST INFORMATIONS: <?php   echo mysqli_get_host_info($conn);?></h5>
        <h5>MY SQL CONNECTION : <?php echo mysqli_ping($conn)? "ALIVE": "NOT ALIVE"; ?>
        <?php }?>
      
    </head>
    <h2>USER APPLICATION</h2>
    <h5>ADD SECTION</h5>
	        <form action="<?php echo $_SERVER['PHP_SELF'] ?>" method="POST">
			<label>Your Email</label>
			<input type="email" name="email"  autocomplete="off" required>
			<?php echo $errors['email']; ?>
			<label>User Name</label>
			<input type="text" name="name" autocomplete="off" required>
			<?php echo $errors['name']; ?>
			<label>Password</label>
			<input type="password" name="password"  pattern="(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{8,}" autocomplete="off" required>
			<?php echo $errors['password']; ?>
			<input type="submit" name="submit" value="Submit">
            <br>
	        <br>
            </form>

            <h5><label>GET ALL SECTION:</label></h5>
            <form action="<?php echo $_SERVER['PHP_SELF'] ?>" method="POST">
            <input type="text" name="getAll" value="GetAll" default='GETALL' readonly>
            <input type="submit" name="getAll" value="GETALL">
            <br>
	        <br>
            </form>

            
           
            <h5><label>EDIT SECTION:</label></h5>
            <form action="<?php echo $_SERVER['PHP_SELF'] ?>" method="POST">
            <label>Enter Your Email:</label>
			<input type="email" name="edit_email"  autocomplete="off" required>
			<?php echo $errors['edit_email']; ?>
			<label>Enter Your Password</label>
			<input type="password" name="edit_password"  autocomplete="off" required>
			<?php echo $errors['edit_password']; ?>
			 <br>
	        <br>
            <label>New User Name</label>
			<input type="text" name="new_username" autocomplete="off"  required>
            
            <label>New Email</label>
			<input type="email" name="new_email" autocomplete="off" required>

            <label>New Password </label>
			<input type="password" name="new_password"   pattern="(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{8,}" autocomplete="off" required>
            <br>
	        <br>

			<input type="submit" name="edit" value="EDIT">
            <br>
	        <br>

           
            </form>

            <h5><label>DELETE SECTION:</label></h5>

            <form action="<?php echo $_SERVER['PHP_SELF'] ?>" method="POST">
            <label>Enter the Email to Delete:</label>
			<input type="email" name="email_to_delete" autocomplete="off" required>
            <input type="submit" name="delete" value="DELETE">
            </form>

            <h5><label>GET BY PARTICULAR ID SECTION:</label></h5>
            <form action="<?php echo $_SERVER['PHP_SELF'] ?>" method="POST">
            <label>Enter id to retrive:</label>
			<input type="text" name="id_to_get" autocomplete="off" required>
            <input type="submit" name="getById" value="GET BY ID">
            </form>


            <form action="<?php echo $_SERVER['PHP_SELF'] ?>" method="POST">
            <h2>Output:</h2>
           
            <?php
            if(isset($_POST['getAll'])){
            ?>
             <div>
            <h2>TABLE:</h2>
            <h4>
            <table> 
            <tr>
                <th>ID</th>
                <th>UserName</th>
                <th>Email</th>
                <th>Created Date</th>
            </tr>
            <tr>
            <?php foreach( array_keys($test) as $index=>$key ) {?>
            <tr>
            <td><?php echo htmlspecialchars( $test[$index]["id"]); ?></td>
            <td><?php echo htmlspecialchars( $test[$index]["userName"]); ?></td>
            <td><?php echo htmlspecialchars($test[$index]["email"]); ?></td>
            <td><?php echo htmlspecialchars($test[$index]["createdDate"]); ?></td>
            </tr>
            <?php } ?>
            </tr>
            </table>
            </h4>
            </div>
            <?php } ?>

            <?php if(isset($_POST['getById'])){ ?>

            <h4><label>Data Correspondence to your input ID is:</label><br></h4>

            <p>Name: <?php echo htmlspecialchars($ret_data["userName"]); ?></p>
             
             <p>Email:  <?php echo htmlspecialchars($ret_data["email"]); ?></p>
             <p>Created Date: <?php echo htmlspecialchars($ret_data["createdDate"]); ?></p>
            <?php } ?> 

            </form>


        

</html>