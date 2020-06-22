<!DOCTYPE html>
<?php session_start(); ?>
<html lang="en" >
<head>
  <meta charset="UTF-8">
  <title>BookYourShow - Admin Panel</title>
  <link rel='stylesheet' href='https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap.min.css'>
  <script src="http://code.jquery.com/jquery-1.10.2.js"></script>
  <link rel="stylesheet" href="./style/admin_style.css">

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

<script type="text/javascript">
$(function() {

  //Hide table by default
  $("#displayUsers").hide();

          //For filtering Booking table
          $("dropdown.dropdown-toggle").click(function(ev) {
              $("button.dropdown-toggle").dropdown("toggle");
              return false;
          });

          $(".dropdown-menu li a").click(function(ev) {

            $(".btn:first-child").text($(this).text());
            $(".btn:first-child").val($(this).text());
            $(".btn:first-child").append(' <span class="caret"></span>');
            var chosenValue = $(this).text();
            window.location.href = "admin_panel.php"+'?day='+chosenValue;
          });

    $("#showUsers").on("click", function(){
        $("#displayUsers").show();
    })
    $("#hideUsers").on("click", function(){
      $("#displayUsers").hide();
    })

    //Delete user upon click of button
    $(".btn-delete").on("click", function(){
      var $tr = $(this).closest('tr');
      var name = $(this).attr("value");
      if (name == "admin") {
         //Do nothing
      } else {
        $.ajax({
          type: "DELETE",
          url: "admin_delete.php?username="+ $(this).attr("value"),
          success: function(){
          $tr.remove();
      } 
    });   
    setTimeout(function(){
    document.location.reload(true); 
    }, 2000);
}
})
    //Validating input for Day
    var allowedDays = ["All","Monday","Tuesday","Wednesday","Thursday","Friday","Saturday","Sunday"];
    $("#dayVal").on("blur", function(){

      var day = $(this).val();
      var index = allowedDays.indexOf(day);

      if(index == -1){

        $("#seatBtn").attr("disabled", true);

      } else {

        $("#seatBtn").removeAttr("disabled");

      }
    })
});
</script>
</head>
<body>
<?php  
    if($_SESSION["admin"] == false) {
    header("Location:landing.html");
} 
?>
<nav class="navbar navbar-inverse navbar-fixed-top">
  <div class="container">
    <div class="navbar-header">
      <a href="index.php" class="navbar-brand">BookYourShow</a>
    </div>
    <div class="collapse navbar-collapse">
      <ul class="nav navbar-nav navbar-right">
        <li><a href="logout.php?hasClick=true">Logout</a></li>
      </ul>
    </div>
  </div>
</nav>
<div class="container-fluid">
  <div class="col-md-3">

    <div id="sidebar">
      <ul class="nav navbar-nav side-bar navbar-fixed-left">
        <li class="side-bar"><a href="admin_panel.php"><span class="glyphicon glyphicon-euro">&nbsp;</span>Bookings</a></li>
        <li class="side-bar"><a href="#movies"><span class="glyphicon glyphicon-film">&nbsp;</span>Movies</a></li>
        <li class="side-bar"><a href="#users"><span class="glyphicon glyphicon-user">&nbsp;</span>Users</a></li>
      </ul>
    </div>

  </div>

  <div class="col-md-9">

    <h1 class="page-header">Bookings Information</h1>
    <div class="dropdown">

      <button 
      id="dropdownMenu" 
      class="btn btn-default dropdown-toggle" 
      type="button" 
      data-toggle="dropdown" 
      aria-haspopup="true" 
      aria-expanded="true">
      Choose<span class="caret"></span>
      </button>

        <ul id="booking" class="dropdown-menu" aria-labelledby="dropdownMenu">
          <li><a href="#">All</a></li>
          <li><a href="#">Monday</a></li>
          <li><a href="#">Tuesday</a></li>
          <li><a href="#">Wednesday</a></li>
          <li><a href="#">Thursday</a></li>
          <li><a href="#">Friday</a></li>
          <li><a href="#">Saturday</a></li>
          <li><a href="#">Sunday</a></li>
        </ul>
    </div>

<?php 
    include "connect.php";

    if(!isset($_GET["day"]) || $_GET["day"] == "All"){

      $sql = "SELECT `Username`, `movie`, `total`, `Seats`,`ShowDay` FROM `log`;";   

    } else {
      $day = $_GET["day"];//chosenValue
      $sql = "SELECT `Username`, `movie`, `total`, `Seats`,`ShowDay` FROM `log` WHERE `ShowDay`='$day';";
    }

    $resultSet = $mysqli->query($sql);

    if($resultSet->num_rows > 0){

      echo "<table border='1' align='center' style= 'border-collapse:collapse; text-align:center'>";
              echo "<thead>";
                 echo "<tr>";
                    echo "<th>Username</th>";
                    echo "<th>Movie</th>";
                    echo "<th>Total</th>";
                    echo "<th>Seats Booked</th>";
                    echo "<th>Show Day</th>";
                 echo "</tr>";
              echo "</thead>";

              echo "<tbody>"; 
        while($row = $resultSet->fetch_array()){
                  echo "<tr>";
                       echo "<td>" . $row['Username'] . "</td>";
                       echo "<td>" . $row['movie'] . "</td>";
                       echo "<td>" . $row['total'] . "</td>";
                       echo "<td>" . $row['Seats'] . "</td>";
                       echo "<td>" . $row['ShowDay'] . "</td>";
                  echo "</tr>";
        }
              echo "<tbody>";
     echo "</table>";
     $resultSet->free();
} else {
  echo "No data found!<br/>";
}
?>

<!-- Reset movie seatings! -->
<div id="movies" class="col-md-9">
  <h1 class="page-header">Movies</h1>

    <form action="movie_reset.php" method="POST">

        <div class="form-group">
          <label>Day(s)</label>
          <input id="dayVal" type="text" class="form-control" name="day" placeholder="E.g All, Monday, Tuesday.." required><br/>
          <label>Movie</label>
          <input type="text" class="form-control" name="movie" placeholder="E.g All, War.." required>
        </div>
        <button id="seatBtn" class="btn btn-success" type="submit">Reset Seats</button> 

    </form>
</div>

<!-- Manipulate Users -->
<div id="users" class="col-md-9">

  <h1 class="page-header">Users</h1>

    <button id="showUsers" type="button" class="btn btn-primary">Show users</button>
    <button id="hideUsers" type="button" class="btn btn-danger">Hide users</button>

      <?php 
        $sql = "SELECT `Username`, `Email`, `Phoneno`, `RegistrationDate` FROM `registration`";
        $resultSet = $mysqli->query($sql);

        if($resultSet->num_rows > 0){
        echo "<table id='displayUsers' border='1' align='center' style= 'border-collapse:collapse; text-align:center;margin-top:15px;'>";
              echo "<thead>";
                 echo "<tr>";
                    echo "<th>Username</th>";
                    echo "<th>Email</th>";
                    echo "<th>Phone Number</th>";
                    echo "<th>Member Since</th>";
                    echo "<th>Action</th>";
                 echo "</tr>";
              echo "</thead>";

              echo "<tbody>";
        while($row = $resultSet->fetch_array()){
                echo "<tr>";
                    echo "<td>" . $row['Username'] . "</td>";
                    echo "<td>" . $row['Email'] . "</td>";
                    echo "<td>" . $row['Phoneno'] . "</td>";
                    echo "<td>" . $row['RegistrationDate'] . "</td>";
                    echo "<td>    <button 
                                  type='button' 
                                  class='btn btn-danger btn-delete' 
                                  value='".$row['Username']."'>Delete user
                                  </button>
                         </td>";
                echo "</tr>";
    }
              echo "</tbody>";
     echo "</table>";
     $resultSet->free();
} else {
  echo "No data found!<br/>";
}       
?>
</div>
</div>
</div>
</div>
    <script src="http://netdna.bootstrapcdn.com/bootstrap/3.0.0/js/bootstrap.js"></script>
</body>
<?php $mysqli->close(); ?>
</html>
