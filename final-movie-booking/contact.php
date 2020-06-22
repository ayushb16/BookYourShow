<?php session_start(); ?>
<!DOCTYPE html>
<html>
<head>
	<title>Contact Us</title>
		<link rel="icon" href="data:;base64,iVBORwOKGO=" />
		<link rel="stylesheet" type="text/css" href="style/nav_style.css">
</head>
<body>
	<?php 
		if(!isset($_SESSION["user"])){
			header("Location: landing.html");
		}
	?>
	<div class="sidenav">
		<a href="index.php">Home</a>
  		<a href="account.php">My Account</a>
  		<a href="bookings.php">My Bookings</a>
  		<a style="color: lightgrey" href="contact.php">Contact</a>
  		<a href="report.php">Report</a>
	</div>

	<div class="main">
		<!-- My Booking Panel -->
		<h1>Contact Us</h1>
		<!-- Form for a suggestion maybe -->
		<form action="sendemail.php" method="post">
			<input
			class = "suggest-box" 
			type="text" 
			name="title" 
			placeholder="Suggest a new movie or tell us about your experience"
			size="50"
			required>
			<br /> 
			<br />
			<textarea 
			rows="10" 
			cols="80" 
			placeholder="Write to us!"
			required></textarea><br /><br />
			<input type="submit" class="contact-btn" name="" value="Send">
			<input type="reset" class="contact-btn" name="reset">
		</form>
	</div>
</body>
</html>