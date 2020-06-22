<?php session_start(); ?>
<!DOCTYPE html>
<html>
<head>
	  <title>My Bookings</title>
    <link rel="icon" href="data:;base64,iVBORwOKGO=" />
    <link rel="icon" href="img/table-solid.svg">
    <link rel='stylesheet' href='https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap.min.css'>
	  <link rel="stylesheet" type="text/css" href="style/nav_style.css">

<style type="text/css">
th {
  text-align: left;
  background: rgba(0, 0, 0, 0.15);
  border-bottom: 1px dashed #aaa;
}

td, th {
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
	<div class="sidenav">
		<a href="index.php">Home</a>
  		<a href="account.php">My Account</a>
  		<a style="color: lightgrey" href="bookings.php">My Bookings</a>
      <a href="report.php">Report</a>
	</div>

	<div class="main">
		<!-- My Booking Panel -->
		<h1>Bookings</h1>

		<!-- Display bookings in tabular format -->
		<?php 
				include "connect.php";
				$username = $_SESSION["user"];

				$sql = "SELECT `movie`, `total`, `DateBooked`, `Seats`, `ShowDay` FROM `log` WHERE `Username`= '$username'";
				$resultSet = $mysqli->query($sql);

				if($resultSet->num_rows > 0){

				echo "<table border='1' align='center' style= 'border-collapse:collapse; text-align:center'>";
                echo "<thead>";
            		 echo "<tr>";
                    	 	echo "<th>Movie</th>";
                    	 	echo "<th>Total</th>";
                        echo "<th>Date Booked</th>";
                        echo "<th>Seats Booked</th>";
                        echo "<th>Show Day</th>";
            		  echo "</tr>";
                echo "</thead>";

                echo "<tbody>";
            	while($row = $resultSet->fetch_array()){
            		echo "<tr>";
                		    echo "<td>" . $row['movie'] . "</td>";
                		    echo "<td>" . $row['total'] . "</td>";
                        echo "<td>" . $row['DateBooked'] . "</td>";
                        echo "<td>" . $row['Seats'] . "</td>";
                        echo "<td>" . $row['ShowDay'] . "</td>";
            		echo "</tr>";
        		}
                echo "</tbody>";
        echo "</table>";

			} else {

    			echo "No data found in database!";
    	}
        		// Free result set
        		$resultSet->free();
        		$mysqli->close();
		?>
	</div>
</body>
</html>