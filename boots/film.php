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
			$film_id = $_GET['id'];
			if( ! is_numeric($film_id) ){
				$film_id = 1;
			}
			$film = $bc->get_film($film_id);
		?>
		<div id="header" class="jumbotron text-center">
        <h1><?=$film['title']?></h1>
      </div>
		<div id="description" class="row">
			<h2><?= $film['description'] ?></h2>
		</div>
		<div id="film-preview" class="row">
			<div id="film-details" class="col-sm-12 col-lg-6 section">
				<h2>Film Details</h2>
				<table class="table table-hover">
					<?php
						foreach($film as $label => $value){
							switch( $label ){
								case "title":
									continue 2;
								case "special_features":
									$value = implode("</br>",explode(",",$value));
									break;
								case "rental_duration":
									$value .= " days";
									break;
								case "rental_rate":
								case "replacement_cost":
									$value = "$" . $value;
									break;
								case "length":
									$value = round($value/60,0) . "h " . $value % 60 . "m";
									break;
								case "description":
									$description = $value;
									continue 2;
									break;
							}
							echo "<tr><th>" . ucwords(implode(" ",explode("_",$label))) . "</th><td>$value</td></tr>";
						}
					?>
				</table>
			</div>
			<div class="col-sm-12 col-lg-6">
				<img id ="film_logo" class="center-block" src="../resources/images/film_logo.png">
				<div id="creep" class="row">
					<img id="creep" class="img-responsive" src="../resources/images/blinds1.jpg">
				</div>
			</div>
		</div>
		<div id="film-table" class="row">
			<h2>Rental History</h2>
			<table class="table table-hover full-width-table">
				<?php
					$rentals = $bc->get_film_rentals($film_id);
					$header = false;
					foreach($rentals as $row){
						echo "<tr>";
						if( ! $header ){
							foreach( $row as $label => $value ){
								if( $label === "customer_id" ){
										continue;
								}
								echo "<th>" . ucwords(strtolower(implode(" ",explode("_",$label)))) . "</th>";
							}
							echo "</tr><tr>";
							$header = true;
						}
						foreach( $row as $label => $value ){
							switch($label){
								case 'customer_id':
									$customer_id = $value;
									break;
								case 'customer':
									echo "<td><a href=\"customer.php?id=$customer_id\">" . $value . "</a></td>";
									break;
								case 'return_status':
									if( $value === "LATE" ){
										echo "<td class=\"alert alert-danger\">$value</td>";
										break;
									}
								default:
									echo "<td>$value</td>";
							}
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
	<script>
		$(function(){
			$('#header').on('click', function(){
				$('#image').fadeOut(200).delay(400).fadeIn(200);
				$('#creep').delay(200).fadeIn(200).fadeOut(200);
			});
		});
		$(function(){
			$('#creep').hide();
		})
	</script>
</body>
</html>