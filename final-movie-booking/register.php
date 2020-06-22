<?php 
	include 'connect.php';

	//Getting all field values from Register form
	$username 	 = $_POST["username"];
	$email 	  	 = $_POST["email"];
	$password 	 = $_POST["password"];
	$phoneNumber = $_POST["phoneno"];

	date_default_timezone_set('Indian/Mauritius');
	//YYYY-MM-DD format
    $date = date('Y-m-d');

	$passwordHash = password_hash($password, PASSWORD_DEFAULT);

	$sql = " INSERT INTO `registration` (`Username`,`Email`,`Password`,`Phoneno`,`RegistrationDate`) 
			 VALUES ('$username', '$email', '$passwordHash', '$phoneNumber', '$date') ";
			 
	$mysqli->query($sql);
	$mysqli->close();

	header("Location:landing.html");

?>