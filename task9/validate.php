<?php

error_reporting(0);
include "connect.php";

    if(isset($_POST['login'])){

                $email = mysqli_real_escape_string($conn, $_POST['email']);
               
                $password = md5(mysqli_real_escape_string($conn, $_POST['password']));
               
                $sql = "SELECT COUNT(*) as totalcount  from test where email='$email' and password='$password'";

                $result=mysqli_query($conn, $sql);
              

                $pizzas = mysqli_fetch_assoc($result);


                if($pizzas['totalcount']>0){
                
                    if(isset($_POST['remember'])){
                        setcookie('email',$email,time()+60*60*7);
                        setcookie('password',$password,time()+60*60*7);
                    }
                    session_start();
                    $_SESSION['email']=$email;

                    header('Location: user.php');

                  //header('Location: user.php');

                }else if($pizzas['totalcount']<=0){
                    echo "<script> alert('email or password is wrong') </script>";
                    header('Location: signin.php');
                } else {
                    echo 'query error: '. mysqli_error($conn);
                }
    }
   else if(isset($_POST['signup'])){


        	$email = mysqli_real_escape_string($conn, $_POST['email']);
			$name = mysqli_real_escape_string($conn, $_POST['name']);
            $password = md5(mysqli_real_escape_string($conn, $_POST['password']));
          
			$sql = "INSERT INTO test(userName,email,password) VALUES('$name','$email','$password')";

			
			if(mysqli_query($conn, $sql)){
	
                header("location: signin.php");
			} else {
				echo 'query error: '. mysqli_error($conn);
            }
        
      
   }
    else{
        header("location: signin.php");
    }


?>