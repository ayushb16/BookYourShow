<?php session_start(); ?>
<!DOCTYPE html>
<html>
<head>
	<title>Report a Problem</title>
    <link rel="icon" href="data:;base64,iVBORwOKGO=" />
    <link rel="icon" href="img/envelope-solid.svg">
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
  		<a style="color: lightgrey" href="report.php">Report</a>
	</div>

	<div class="main">
		<h2>Send us an email!</h2>
		<form action="report_send.php" method="post">

            <label style="font-family: sans-serif;font-weight: bold">Subject </label>
            <input 
            name="subject"
            class="report" 
            type="text" 
            size="25"
            required><br/>

    		<textarea 
    		name="message" 
    		rows="15" 
    		cols="100" 
    		placeholder="Enter Your Message"
            maxlength="5000" 
            required></textarea><br/>
    		<input class="contact-btn" type="submit" name="submit" value="Submit Message"/>
            <input class="contact-btn" type="reset" value="Reset">
		</form>
	</div>
</body>
</html>