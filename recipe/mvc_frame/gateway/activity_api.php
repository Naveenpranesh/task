<?php
include_once("../framework/initialise/framework.init.php");
global $request,$db,$curl;
console(LOG_LEVEL_TRACE, "Incoming Request ::".var_export($request, true)); 
$date = date("Y-m-d");

if($request['type']=='usage'){
	$sql7 = "SELECT username AS user_name,a.user_in FROM mt_activity a JOIN mtsoc_auth_users u ON a.user_id=u.id WHERE DATE(user_in)='".$date."' ";
	$truemove = $db['master']->getResults($sql7);
}
else if($request['type']=='count'){
	$sql6 = "SELECT username AS user_name,COUNT(*) AS cnt FROM mt_activity a JOIN mtsoc_auth_users u ON a.user_id=u.id WHERE DATE(user_in)='".$date."' GROUP BY a.user_id";
	$truemove = $db['master']->getResults($sql6);
}
//print_r($truemove);
$response = json_encode($truemove,JSON_FORCE_OBJECT);  
echo $response;  
console(LOG_LEVEL_TRACE, "API Result :: ".$response);
?>