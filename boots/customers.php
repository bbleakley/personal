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
      <div id="header" class="jumbotron text-center">
        <h1>Customers</h1>
      </div>
		<div class = "row">
      <div class="col-xs-12 col-lg12"
			<div class="table-responsive">
        <table class="table table-hover full-width-table">
					<?php
						include('../baseController.php');
						$bc = new baseController();
						$query =
"select
  customer.customer_id,
	concat(customer.first_name, ' ', customer.last_name) as name,
	customer.email,
	address.address,
	city.city,
	country.country
from customer
inner join address
	 on customer.address_id = address.address_id
inner join city
	on address.city_id = city.city_id
inner join country
	on city.country_id = country.country_id
where customer.active = 1
order by last_name;";
						$values = $bc->query($query);
            $header = false;
						foreach( $values as $row ){
              echo "<tr>";
              if( ! $header ){
                foreach( $row as $label => $value ){
                  if( $label === "customer_id" ){
                    continue;
                  }
                  echo "<th>" . ucwords(implode(" ",explode("_",$label))) . "</th>";
                }
                echo "</tr><tr>";
                $header = true;
              }
              foreach( $row as $label => $value ){
                if( $label === "customer_id" ){
                  $customer_id = $value;
                  continue;
                }
                if( $label === "name" ){
                  echo "<td><a href=\"customer.php?id=$customer_id\">" . ucwords(strtolower($value)) . "</a></td>";
                  continue;
                }
                echo "<td>$value</td>";
              }
              echo "</tr>";
            }
					?>
          </table>
          </div>
			</div>
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