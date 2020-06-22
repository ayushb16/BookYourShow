<?php 
	include "connect.php";

	$username = $_POST["username"];
	$email    = $_POST["email"];

		if (isset($_POST["username"])) {

        	$sql      = "SELECT `Username`, `Email` FROM `Registration` WHERE `Username` = ? OR `Email` = ?";

			$stmt = $mysqli->prepare($sql);
			//Bind input values with their repective data type: s => string
			$stmt->bind_param("ss",$username, $email);
			$stmt->execute();

			$result = $stmt->get_result();
			$stmt->close();
        	$count  = $result->num_rows;
        	echo $count;
        	$result->free();
		}
	$mysqli->close();
?>