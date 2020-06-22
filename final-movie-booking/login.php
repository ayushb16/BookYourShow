<?php 
		session_start();	
		$username = $_POST["username"];
		$_SESSION["user"] = $username;
		$_SESSION["isLogged"] = true;
		$_SESSION["admin"] = false;//for else clause in index.php

		if($username == "admin"){
			$_SESSION["admin"] = true;
		}
		header("Location:index.php");
		
?>