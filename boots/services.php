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
  <div class="container-fluid">
    <div id="main">
      <div id="mySidenav" class="sidenav">
        <a href="javascript:void(0)" class="closebtn" onclick="closeNav()">&times;</a>
        <a href="/boots/about.php">About</a>
        <a href="/boots/services.php">Services</a>
        <a href="/boots/customers.php">Customers</a>
        <a href="#">Contact</a>
      </div>
      <div class="jumbotron text-center">
        <h1>Services</h1>
      </div>
      <div class="row">
        <div class="col-sm-12 col-lg-6">
          <h2>Movie rentals</h2>
          <p>Sakila Movie Rental boasts one of the largest collections of fine films in the world.</p>
          <p>With two convenient locations in Canada and Australia, we make it easy to find your favorite films.</p>
          <p>Come rent a drama with Fina Degeneres, an action film with Walter Torn or a salacious thriller with Mary Keitel!</p>
          <p>If you're looking for great films, you've come to the right place!</p>
        </div>
        <div class="col-sm-12 col-lg-6">
          <img class="img-responsive" src="../resources/images/movie_rentals.jpg">
        </div>
      </div>
      <div class="row">
        <div class="col-sm-12 col-lg-6">
          <img class="img-responsive" src="../resources/images/blinds.jpg">
        </div>
        <div class="col-sm-12 col-lg-6">
          <h2>Creeping</h2>
          <p>have you ever seen a movie about the government watching somebody and collecting as much data as possible about him or her?</p>
          <p>Ever wonder if that was happening to you?</p>
          <p>While all signs point to yes on the government side, I can say for certain that Sakila is doing our part and collecting and storing all sorts of information about our customers, stores, films and more!</p>
          <p>We understand that may make you uncomfortable</p>
        </div>
      </div>
      <div class="row">
        <div class="col-sm-12 col-lg-6">
          <h2>Data Analysis</h2>
          <p>Thanks to all of the data we've silently aquired from our wonderful customers, we've been able to construct a detailed database.</p>
          <p>Now we're opening our extensive records to the public!</p>
          <p>Enjoy all these benefits of our database:</p>
          <ul>
            <li>Filter and sort our list of films to find exactly what you're looking for!</li>
            <li>Find out which one of your coworkers watches the most NC-17 films!</li>
            <li>Track down the hot chick who in front of you in line last time!</li>
          </ul>
        </div>
        <div class="col-sm-12 col-lg-6">
          <img class="img-responsive" src="../resources/images/database.jpg">
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