<?php 
	session_start();
	include "connect.php";
	$username = $_SESSION["user"];
	$total = $_POST["amount"];
	$movie = $_POST["movie"];
	$day = $_POST["dayBooked"];
	$seats = $_POST["seatsArray"];

	$seatsToString = implode(",", $seats);

	date_default_timezone_set('Indian/Mauritius');

	//YYYY-MM-DD format
    $date = date('Y-m-d');
    if ($total != 'Rs 0') {
    	
    	$sql = "INSERT INTO `log`(`Username`,`movie`,`total`,`DateBooked`,`Seats`, `ShowDay`) 
    	        VALUES ('$username','$movie','$total', '$date', '$seatsToString', '$day')";	
    }

	$mysqli->query($sql);

	//Loop through seats array and for each value insert
	foreach ($seats as $seatsArray => $value) {
		//Log into seatsbooked
		$sql2 = "INSERT INTO `seatsbooked`(`Movie`,`Seats`,`DayBooked`) VALUES ('$movie','$value','$day')";

		$mysqli->query($sql2);
	}

	$mysqli->close();
?>