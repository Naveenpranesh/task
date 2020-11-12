<?php
error_reporting(0);
session_start();
session_destroy();
if(isset($_COOKIE['email']) && isset($_COOKIE['password'])){
      $email=$_COOKIE['email'];
  $password=$_COOKIE['password'];
setcookie('email',$email,time()-3600);
setcookie('password',$password,time()-1);

}
header('Location: signin.php');

?>