<?php session_start(); ?>
<!DOCTYPE html>
<html>
<head>
	<title>My Account</title>
	<link rel="icon" href="data:;base64,iVBORwOKGO=" />
	<link rel="icon" href="img/user-solid.svg">
	<link rel='stylesheet' href='https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap.min.css'>
	<link rel="stylesheet" type="text/css" href="style/nav_style.css">

<script type="text/javascript">

	function changeUserNameAJAX(){

		var username = document.getElementById("name");

		if(username.value == ""){

			alert("Field should not be empty!");
			return false;

		} else {
		var xhr = new XMLHttpRequest();
		xhr.open("GET", "change_name.php?name="+username.value, true);
		xhr.setRequestHeader("Content-Type", "application/json;charset=UTF-8");

		xhr.onreadystatechange = function(){

			  if (this.readyState == 4 && this.status == 200) {

			  	var data = JSON.parse(xhr.responseText);
			  	//Check if already exist: change border color to red
   			  	if(data.hasError == true){
   			  	//Same name
   			  	document.getElementById("name").style.color = "red";

   			  } else {

   			  	document.getElementById("name").style.color = "green";
   			  	//Reload after 2 seconds
   			  	 setTimeout(function(){
   			  	 	document.location.reload(true); 
   			  	 }, 2000);
   			  }
  		}
	}
	xhr.send(null);
	}
}
</script>
<style type="text/css">

th {
  display: none;
}

td.heading {

  font-family: 'Sans-serif';
  font-size: 18px;
  font-weight: bold;
  background: rgba(0, 0, 0, 0.15);
}

td {

  padding: .625em;
  line-height: 1.5em;
  border-bottom: 1px #ccc;
  box-sizing: border-box;
  overflow-x: hidden;
  overflow-y: auto;
}

</style>
</head>


<body>
	<?php 
		if(!isset($_SESSION["user"])){
			header("Location: landing.html");
		}
	?>
	<!-- Sidebar -->
	<div class="sidenav">
		<a href="index.php">Home</a>
  		<a style="color: lightgrey" href="account.php">My Account</a>
  		<a href="bookings.php">My Bookings</a>
  		<a href="report.php">Report</a>
	</div>

	<!-- My Account Panel -->
	<div class="main">

		<!-- To display details from registration table -->
		<h1>Account</h1>

		<div id="myAccount">
			<?php 
				include "count_bookings.php";
				$username     =  $_SESSION["user"];
				$noOfBookings = countBookings($username);
				
				include "connect.php";

				$sql1 = "SELECT `Username`,`Email`,`Phoneno`,`RegistrationDate` FROM `registration` WHERE `Username`='$username'";

				$resultSet = $mysqli->query($sql1); 
            	$row = $resultSet->fetch_array();

				//No need to count rows or use while loop; will definitely return exactly 1 row per user
				echo "<table border='1' align='center' style= 'border-collapse:collapse; text-align:center'>";

            		 echo "<tr>";
                	 	echo "<th>Type</th>";
                	 	echo "<th>Value</th>";
            		 echo "</tr>";

            		echo "<tr>";
            				echo "<td class='heading'>Username</td>";
            				echo "<td>". $row["Username"] . "</td>";
            		echo "</tr>";
            		echo "<tr>";
            				echo "<td class='heading'>Email</td>";
            				echo "<td>". $row["Email"] . "</td>";
            		echo "</tr>";
            		echo "<tr>";
            				echo "<td class='heading'>Phone Number</td>";
            				echo "<td>". $row["Phoneno"] . "</td>";
            		echo "</tr>";
            		echo "<tr>";
            				echo "<td class='heading'>Member Since</td>";
            				echo "<td>". $row["RegistrationDate"] . "</td>";
            		echo "</tr>";
            		echo "<tr>";
            				echo "<td class='heading'>Movies Booked</td>";
            				echo "<td>". $noOfBookings . "</td>";
            		echo "</tr>";

        		echo "</table>";
        		$resultSet->free();
        		$mysqli->close();
			?>
			<!-- Refer to logout(); -->
			<form method="POST">
				<input
				style= "outline: none;"
				id="logout" 
				type="submit" 
				name="logout" 
				value="Log Out">
			</form>	

			<!-- Changing user information -->
			<div style="margin-top: 10px;" class="form-group">
				<div class="col-xs-2">
				<label >New username</label>
				<input 
				 type="text" 
				 id="name" 
				 class="form-control input-sm" 
				 size="30" 
				 name="newUserName"
				 title="Required">							
				</div>
				<button 
				onclick="changeUserNameAJAX();" 
				id="changeName" 
				style="margin-top: 30px;" 
				type="button" 
				class="btn btn-primary">
				Change
				</button>
			</div>
		</div>
	</div>
</body>

<?php 
		function logout(){

			//Prevent user from going back to account.php after logging out!
			unset($_SESSION["user"]);
			unset($_SESSION["isLogged"]);
			session_destroy();
			header("Location:welcome.html");
		}

		if(array_key_exists("logout", $_POST)){
			logout();
		}
?>
</html>