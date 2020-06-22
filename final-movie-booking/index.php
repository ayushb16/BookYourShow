<!DOCTYPE html>
<?php session_start(); ?>
<html lang="en" >
<head>
  <meta charset="UTF-8">
  <title>Movie Booking System | BookYourShow</title>
  <link rel="icon" href="data:;base64,iVBORwOKGO=" />
  <!-- Logo in tab -->
  <link rel="icon" href="img/film.png">
  <!-- Font Imports -->
  <link rel='stylesheet' href='https://fonts.googleapis.com/css?family=Roboto:100,400'>
  <link rel='stylesheet' href='https://fonts.googleapis.com/css?family=Khula'>
  <link rel='stylesheet' href='https://cdnjs.cloudflare.com/ajax/libs/material-design-iconic-font/2.2.0/css/material-design-iconic-font.min.css'>
  <!-- jQuery file -->
  <script src='https://cdnjs.cloudflare.com/ajax/libs/jquery/3.1.1/jquery.min.js'></script>
  <!-- CSS File -->
  <link rel="stylesheet" href="style/main.css">
</head>

<body>
<!-- wrapper class is for the whole panel -->
<div class="wrapper"> 
	<!-- Start of side panel -->
	<div class="side">
		<div class="bg"></div>
		<div>
			<h3>BookYourShow</h3>
		</div>
		<input type="text" class="search" placeholder="Search" />
		<ul class="menu">
			<li data-id = "0" class="selected" title="Monday For All"><i class="zmdi zmdi-accounts-alt"></i>Monday</li>
			<li data-id = "1" title="Kids Tuesday"><i class="zmdi zmdi-face"></i>Tuesday</li>
			<li data-id = "2" title="Wednesday Midday"><i class="zmdi zmdi-label-alt"></i>Wednesday</li>
			<li data-id = "3" title="Ladies Night"><i class="zmdi zmdi-female"></i><span>Thursday</span></li>
			<li data-id = "4" title="Family Friday"><i class="zmdi zmdi-male-female"></i><span class="friday">Friday</span></li>
			<li data-id = "5" title="Boys Night"><i class="zmdi zmdi-male-alt"></i><span>Saturday</span></li>
			<li data-id = "6" title="Sunday Funday"><i class="zmdi zmdi-mood"></i>Sunday</li>
			<li data-id = "7" class="divider">
				<i class="zmdi zmdi-calendar"></i> Coming Soon
			</li>
		</ul>
	</div>
	<!-- End of side panel -->

	<div class="main-wrap">
		<div class="main">
			<div class="list">
				<div class="scroll">
					<!-- Scroll Buttons -->
					<!-- i element is used to get icons from the icon library imported -->
					<button class="scrollTop"><i class="zmdi zmdi-arrow-left"></i></button>
					<button id="down" class="scrollDown"><i class="zmdi zmdi-arrow-right"></i></button>
				</div>
				<header>
					<ul class="filter">
						<!-- The data-gid refers to genre IDs of API of tmbd -->
						<li data-gid=",">All</li>
						<li data-gid="28">Action</li>
						<li data-gid="12">Adventure</li>
						<li data-gid="35">Comedy</li>
						<li data-gid="18">Drama</li>
						<li data-gid="878">Sci-Fi</li>
					</ul>
				</header>
				<div class="content">
					<ul class="covers"></ul>
				</div>
			</div>
			<div class="checkout">
				<div class="sinopsis">
					<button class="back">
						<i class="zmdi zmdi-arrow-left"></i>
					</button>
					<!-- Dynamically update movie information from scripts/script.js-->
					<!-- It also contains the API Key -->
					<img class="cover" 
					src="data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAAEAAAABCAQAAAC1HAwCAAAAC0lEQVR42mP8zw8AAhMBENYXhyAAAAAASUVORK5CYII=" 
					style="background-image: url(https://image.tmdb.org/t/p/w300//gfJGlDaHuWimErCr5Ql0I8x9QSy.jpg)">
					<!-- w300 represents the img size and it is the smallest supported img to fit as a poster -->
					<h3>Wonder Woman ()</h3>
					<p>An Amazon princess comes to the world of Man to become the greatest of the female superheroes.</p>
					<strong>
						<span>Wed, 28 Jun</span>
					</strong>
					<small></small>		
				</div>
					<section>
					<ul class="legend">
						<li>available</li>
						<li>taken</li>
					</ul>
						<span>Select your seats</span>
						<div class="seats"></div>
						<div class="screen">Screen</div>
					</section>
				<div id="amount" class="total">
					<small>Total </small><span>Rs 0</span>
					<button>CHECKOUT</button>
					<div class="loader"></div>
				</div>				
			</div>
		</div>
	</div>
</div>

	<button class="open-button">My Account</button>
<?php 	
	function checkLogin(){

		if(isset($_SESSION["isLogged"]) && $_SESSION["isLogged"] == true){

			//Load data only if logged in to avoid booking of anonymous ticket
			echo "<script type='text/javascript' src='scripts/script.js'></script>";

			echo "<script type='text/javascript'>";

			echo "$('.open-button').on('click', function(){";

			if($_SESSION["admin"] == true){

				echo "window.location.href = 'admin_panel.php';";

			} else {

				echo "window.location.href = 'account.php';";

			}
			echo "});";
			echo "</script>";

		} else {
			//Unauthorised access!
			header("Location:landing.html");
		}
	}
	checkLogin(); 
?>
</body>
</html>