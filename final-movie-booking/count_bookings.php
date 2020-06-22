<?php 

function countBookings($username){
	
	include "connect.php";
	$sql = "SELECT * FROM log WHERE `Username`='$username'";
	$result = $mysqli->query($sql);
	$count = $result->num_rows;
	$result->free();
	$mysqli->close();
	return $count;
}

?>