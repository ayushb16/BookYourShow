<?php 
	include "connect.php";

	$title = $_POST["movie"];
	$day = $_POST["dayOfBooking"];

	$seats = array();

	$sql = "SELECT `Seats` FROM `seatsbooked` WHERE Movie='$title' AND DayBooked='$day' ";

	$result = $mysqli->query($sql);

	if($result->num_rows > 0){

		while($row = $result->fetch_array()){
			
			//Push value to array
			array_push($seats, $row["Seats"]);

		}

	}
	$result->free();
	$mysqli->close();

	echo json_encode($seats);

?>