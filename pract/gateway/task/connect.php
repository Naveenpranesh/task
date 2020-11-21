<?php 
error_reporting(0);
	// connect to the database
	$conn = mysqli_connect('localhost', 'naveen', '824612', 'task4');

	// check connection
	if(!$conn){
		echo 'Connection error: '. mysqli_connect_error();
    }
    if (!mysqli_ping($conn)) {
        echo 'Lost connection, exiting after query #1';
        exit;
    }
?>