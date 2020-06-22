<?php 
		include 'connect.php';
		$username = $_POST["username"];
		$password = $_POST["password"];


		$sql = " SELECT `Username`, `Password` FROM `Registration` 
				 WHERE `Username`  = ?";

		$stmt = $mysqli->prepare($sql);
		$stmt->bind_param("s",$username);
		$stmt->execute();

		$result = $stmt->get_result();
		$stmt->close();

		$count = $result->num_rows;

		if($count > 0){

			while ($row = $result->fetch_array()) {

			if ($row["Username"] == $username && password_verify($password, $row["Password"])) {
				echo $count;
				break;
			} 
		}
	}
		$result->free();
		$mysqli->close();
?>