<?php 
	session_start();

	if(isset($_GET["hasClick"]) && $_GET["hasClick"] == true){
		
	   unset($_SESSION["user"]);
       unset($_SESSION["admin"]);
       session_destroy();
       header("Location:welcome.html");
	}
?>