<!DOCTYPE html>
<html>
<head>
	<?php
		include('../baseController.php');
		$bc = new baseController();
		$customer_id = $_GET['id'];
		if( ! is_numeric($customer_id) ){
			$customer_id = 1;
		}
		$customer = $bc->get_customer($customer_id);
	?>
	<title>Sakila - <?=$customer['full_name']?></title>
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
		<div id="header" class="jumbotron text-center">
        <h1><?=$customer['full_name']?></h1>
      </div>
		<div class="row">
			<div class="col-sm-12 col-lg-6">
				<h2>Personal Info</h2>
				<table class="table table-hover">
					<?php
						foreach($customer as $label => $value){
							switch( $label ){
								case "full_name":
									continue 2;
								case "first_name":
								case "last_name":
									$value = ucwords(strtolower(implode(" ",explode("_",$value))));
									break;
								case "phone":
									$value = "(" . substr($value,0,3) . ") " . substr($value,3,3) . "-" . substr($value,6,4);
									break;
								case "address":
									$address = "<address>$value</br>";
									continue 2;
								case "city":
								case "district":
								case "country":
									$address .= "$value</br>";
									continue 2;
								case "postal_code":
									$value = $address . $value . "</address>";
									$label = "address";
									break;
							}
							echo "<tr><th>" . ucwords(implode(" ",explode("_",$label))) . "</th><td>$value</td></tr>";
						}
					?>
				</table>
			</div>
			<div class="col-sm-12 col-lg-6">
				 <img class="img-responsive" src="../resources/images/customer.jpg">
			</div>
		</div>
		<div id="charts" class="row">
			<div class="col-md-12 col-lg-6">
				<h2>Rentals by Category</h2>
				<div id="piechart" class="center-block">
				</div>
			</div>
			<div class="col-md-12 col-lg-6">
				<h2>Favorite Actors</h2>
				<div id="barchart">
				</div>
			</div>
		</div>
		<div id="customer-rentals" class="row">
			<h2>Rental History</h2>
			<table class="table table-hover full-width-table">
				<?php
					$rentals = $bc->get_customer_rentals($customer_id);
					$header = false;
					foreach($rentals as $row){
						echo "<t>";
						if( ! $header ){
							foreach( $row as $label => $value ){
								switch( $label ){
									case "film_id":
										continue 2;
								}
								echo "<th>" . ucwords(implode(" ",explode("_",$label))) . "</th>";
							}
							echo "</tr><tr>";
							$header = true;
						}
						foreach( $row as $label => $value ){
							switch($label){
								case 'film_id':
									$film_id = $value;
									break;
								case 'title':
									echo "<td><a href=\"film.php?id=$film_id\">$value</a></td>";
									break;
								case 'return_status':
									if( $value === "LATE" ){
										echo "<td class=\"alert alert-danger\">$value</td>";
										break;
									}
								case "rating":
										switch($value){
											case "PG":
												echo "<td id=\"pg-rating\">$value</td>";
												continue 2;
											case "G":
												echo "<td id=\"g-rating\">$value</td>";
												continue 2;
											case "NC-17":
												echo "<td id=\"nc17-rating\">$value</td>";
												continue 2;
											case "PG-13":
												echo "<td id=\"pg13-rating\">$value</td>";
												continue 2;
											case "R":
												echo "<td id=\"r-rating\">$value</td>";
												continue 2;
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
	<script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>

	<script type="text/javascript">
		// Load google charts
		google.charts.load('current', {'packages':['corechart']});
		google.charts.setOnLoadCallback(drawChart);
		google.charts.setOnLoadCallback(drawBarChart);
		// Draw the chart and set the chart values
		function drawChart() {
			var data = google.visualization.arrayToDataTable( <?=$bc->get_customer_categories($customer_id)?> );

			// Optional; add a title and set the width and height of the chart
			var options = {'width':500, 'height':400};

			// Display the chart inside the <div> element with id="piechart"
			var chart = new google.visualization.PieChart(document.getElementById('piechart'));
			chart.draw(data, options);
		}
		function drawBarChart() {
			var data = google.visualization.arrayToDataTable( <?= $bc->get_customer_actor($customer_id) ?> );

			// Optional; add a title and set the width and height of the chart
			var options = {'width':400, 'height':400};

			// Display the chart inside the <div> element with id="piechart"
			var chart = new google.visualization.BarChart(document.getElementById('barchart'));
			chart.draw(data, options);
		}
	</script>

</body>
</html>