<?php 
	session_start();
	include "connect.php";

	if($_SESSION["admin"] == false) {
    header("Location:landing.html");
} 

	$day   = $_POST["day"];
	$movie = $_POST["movie"];

	if($day == "All" && $movie == "All"){

		$sql_1 = "DELETE FROM `log`;";
		$sql_2 = "DELETE FROM `seatsbooked`;";
		$mysqli->query($sql_1);
		$mysqli->query($sql_2);

	} else if($day == "All" && $movie != "All"){

		$sql_3 = "DELETE FROM `log` WHERE `movie`='$movie';";
		$sql_4 = "DELETE FROM `seatsbooked` WHERE `Movie`='$movie';";
		$mysqli->query($sql_3);
		$mysqli->query($sql_4);		

	} else if($day != "All" && $movie == "All"){

		$sql_5 = "DELETE FROM `log` WHERE `ShowDay`='$day';";
		$sql_6 = "DELETE FROM `seatsbooked` WHERE `DayBooked`='$day';";
		$mysqli->query($sql_5);
		$mysqli->query($sql_6);

	} else {

		$sql_7 = "DELETE FROM `log` WHERE `ShowDay`='$day' AND `movie`='$movie';";
		$sql_8 = "DELETE FROM `seatsbooked` WHERE `DayBooked`='$day' AND `Movie`='$movie';";
		$mysqli->query($sql_7);
		$mysqli->query($sql_8);	

}
	$mysqli->close();
	header("Location:admin_panel.php");
?>