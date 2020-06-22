<?php 

/*
Before deleting user, find all movies that were booked by that user ==> reverse the bookings from seatsbooked!
Remove all corresponding entries from log table
Finally remove user from registration!
*/
	include "connect.php";
	$username = $_GET["username"];

	$sql_1 = "SELECT `movie`, `Seats`, `ShowDay` FROM `log` WHERE `Username`='$username';";
	$resultSet = $mysqli->query($sql_1);

	if($resultSet->num_rows == 0){
		//No movies booked! Move straight away to removal from registration
		$sql_2 = "DELETE FROM `registration` WHERE `Username`='$username';";
		$mysqli->query($sql_2);
		$mysqli->close();

	} else {
		//Remove from seatsbooked and then log, then registration
		while($row = $resultSet->fetch_array()){

				$movie = $row["movie"];
				$seat = $row["Seats"];//1 string of seats
				$day = $row["ShowDay"];
				$seats_str =  explode (",", $seat); 

				foreach ($seats_str as $seat) {
					$sql_3 = "DELETE FROM `seatsbooked` WHERE `Movie`='$movie' AND `Seats`='$seat' AND `DayBooked`='$day';";
					$mysqli->query($sql_3);
				}
		}	
		//All data from seatsbooked deleted relating to specific user!

		//Delete from log
		$sql_4 = "DELETE FROM `log` WHERE `Username`='$username'";
		$mysqli->query($sql_4);	
	
		//Finally, delete from registration
		$sql_5 = "DELETE FROM `registration` WHERE `Username`='$username';";
		$mysqli->query($sql_5);
		$resultSet->free();
		$mysqli->close();
	}
?>