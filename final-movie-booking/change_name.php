<?php 
	session_start();
	include "connect.php";
	$oldUserName = $_SESSION["user"];
	$username = $_GET["name"];
	$data = (object) array("hasError" => false);

	if($oldUserName == $username){
		$data->hasError = true;

	} else {

		//Check if username provided already exists
		$sql = "SELECT `Username` FROM `registration` WHERE `Username` = ?";

		$stmt = $mysqli->prepare($sql);
		$stmt->bind_param("s",$username);
		$stmt->execute();

		$resultSet = $stmt->get_result();
		$stmt->close();
	
		if($resultSet->num_rows > 0){
			//Username already exists!
			$data->hasError = true;

		} else {
			//Valid name: make changes!
			$sql_2 = " UPDATE `registration` SET `Username`='$username' WHERE `Username`='$oldUserName';";
			$sql_3 = " UPDATE `log` SET `Username`='$username' WHERE `Username`='$oldUserName';";
			$mysqli->query($sql_2);
			$mysqli->query($sql_3);
			//Change session variable
			$_SESSION["user"] = $username;
		}
		$resultSet->free();

}
	echo json_encode($data);
	$mysqli->close();
?>