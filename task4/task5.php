<?php

include 'class.php';
$num="";
$operator="";
$result ="";
$cookie_name1="num";
$cookie_value1="";
$cookie_name2="op";
$cookie_value2="";

if(isset($_POST['display'])){
    $num=$_POST['display'] ;

}

if(isset($_POST['submit'])){
    $num = $_POST['display'] . $_POST['submit'];

}else{
    $num="";
}
if(isset($_POST['op'])){
    $cookie_value1=$_POST['display'];
   
    setcookie($cookie_name1,$cookie_value1,time()+(86400*30),"/");


    $cookie_value2=$_POST['op'];
    setcookie($cookie_name2,$cookie_value2,time()+(86400*30),"/");
      
    $num="";
}

if(isset($_POST['equals'])){
    $num=$_POST['display'];

    $results = new simpleCal($num,$_COOKIE['num'],$_COOKIE['op']);

   $num=$results->calculation();
}

?>

<html>
<head>
<title> Calculator Apps Using PHP</title>
</head>
<body>
<center>
<form action="<?php echo $_SERVER['PHP_SELF'] ?>" method="POST">
<table border="1">
<tr>
    <td colspan="4">
    <input type="text" name="display" value="<?php echo $num; ?>"/>

    </td>
</tr>
    <tr>
         <td><input type="submit" name="submit" value="7"/></td>
         <td><input type="submit" name="submit" value="8"/></td>
         <td><input type="submit" name="submit" value="9"/></td>
         <td><input type="submit" name="op" value="/"/></td>
         
    </tr>
    <tr>
         <td><input type="submit" name="submit" value="4"/></td>
         <td><input type="submit" name="submit" value="5"/></td>
         <td><input type="submit" name="submit" value="6"/></td>
         <td><input type="submit" name="op" value="+"/></td>
         
    </tr>
    <tr>
         <td><input type="submit" name="submit" value="1"/></td>
         <td><input type="submit" name="submit" value="2"/></td>
         <td><input type="submit" name="submit" value="3"/></td>
         <td><input type="submit" name="op" value="-"/></td>
         
    </tr>
    <tr>
         <td><input type="submit" name="submit" value="0"/></td>
         <td><input type="submit" name="submit" value="00"/></td>
         <td><input type="submit" name="equals" value="="/></td>
         <td><input type="submit" name="op" value="x"/></td>
         
    </tr>
</table>
</form>
</center>
</body>
</html>