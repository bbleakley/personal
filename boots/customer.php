<!DOCTYPE html>
<html>
<head>
  <title>Sakila - Services</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
  <link rel="stylesheet" href="../CSS/boots.css" type="text/css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
</head>
<body>
  <span id="menuButton" style="font-size:30px;cursor:pointer" onclick="openNav()">&#9776; Menu</span>
  <div class = "container-fluid">
    <div id="main">
      <div id="mySidenav" class="sidenav">
        <a href="javascript:void(0)" class="closebtn" onclick="closeNav()">&times;</a>
        <a href="/boots/about.php">About</a>
        <a href="/boots/services.php">Services</a>
        <a href="/boots/customers.php">Customers</a>
        <a href="#">Contact</a>
      </div>
		<?php
			include('../baseController.php');
			$bc = new baseController();
			$customer_id = $_GET['id'];
			$customer = $bc->get_customer($customer_id);
		?>
		<div class="jumbotron text-center">
        <h1><?=$customer['full_name']?></h1>
      </div>
		<div class="row">
			<div class="col-sm-12 col-lg-9">
				<h2>Personal Info</h2>
				<table class="table table-hover">
					<?php
						foreach($customer as $label => $value){
							echo "<tr><td>" . ucwords(implode(" ",explode("_",$label))) . "</td><td>$value</td></tr>";
						}
					?>
				</table>
			</div>
			<div class="col-sm-12 col-lg-3">
				 <img class="img-responsive" src="../resources/images/actor.jpg">
			</div>
		</div>
		<div class="row">
			<h2>Rental History</h2>
			<table class="table table-hover">
				<?php
					$rentals = $bc->get_rentals($customer_id);
					$header = false;
					foreach($rentals as $row){
						echo "<t>";
						if( ! $header ){
							foreach( $row as $label => $value ){
								echo "<th>" . ucwords(implode(" ",explode("_",$label))) . "</th>";
							}
							echo "</tr><tr>";
							$header = true;
						}
						foreach( $row as $label => $value ){
							echo "<td>$value</td>";
						}
						echo "</tr>";
					}
				?>
			</table>
		</div>
  </div>
  <div class="footer">
      <div class="footercontent">
        <p>Patent pending but please don't steal from us while we get out legal shit figured out.</p>
      </div>
  </div>
  <script>
    function openNav() {
        document.getElementById("mySidenav").style.width = "250px";
        document.getElementById("main").style.marginLeft = "250px";
        document.getElementById("menuButton").style.visibility = "hidden";
    }
    function closeNav() {
        document.getElementById("mySidenav").style.width = "0";
        document.getElementById("main").style.marginLeft= "0";
        document.getElementById("menuButton").style.visibility = "visible";
    }
  </script>
</body>
</html>