<?php 
	$mysqli = new mysqli("localhost", "root", "", "moviebooking");

	if($mysqli->connect_error){
		die("Connection to server unsuccessful " . $mysqli->connect_error);
	}else{
		//echo "Connection to server successful: " . $mysqli->host_info;
	}
?>