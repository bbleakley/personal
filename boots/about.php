<!DOCTYPE html>
<html>
<head>
    <title>Sakila - About Us</title>
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
            <div id = "header" class="jumbotron text-center">
                <h1>About Us</h1>
            </div>
            <div class="row">
                <div class="col-sm-12 col-lg-4">
                    <h2>Origins</h2>
                    <p>The child of two coal miners, George Sakila grew up in a humble shack in the hills of West Viginia.</p>
                    <p>Born deaf, dumb and blind, young George took solace in the comforts of his bed and the company of his imaginary best fried, Mr. Shnazzle.</p>
                    <p>Through the modern medical miracle known as magic, his senses were restored and he rejoiced.</p>
                    <p>Eager to make up for all he had missed during his dark younger years, George went out and found a good paying job. He promptly quit as soon as he had saved enough for a used VCR.</p>
                    <p>With his trusted VCR, George set out to watch all the good movies he had never been able to enjoy.</p>
                </div>
                <div class="col-sm-12 col-lg-4">
                    <h2>Sakila Movie Rental</h2>
                    <p>Mr. Sakila's love of film transitioned to a career when he opened his first film rental store in '98 in a small storefront in Alberta.</p>
                    <p>He lost that store during a particularly grim chapter in the history of his gambling addiction on the night of the grand opening.</p>
                    <p>Desperate to get back on top, Mr. Sakila took out a small loan from local booky and birthday clown, Jimmy Smiles</p>
                    <p>Following a hot hand in a high stakes game of blackjack, Mr. Saila was able to pull himself up by his bootstrams.</p>
                    <p>Sakila Movie Rental now boasts two stores on opposite sides of the world, staffed by two very competent employees.</p>
                </div>
                <div class="col-sm-12 col-lg-4">
                    <h2>Future</h2>
                    <p>The future is bright for Sakila Movie Rentals!</p>
                    <p>With two thriving stores and nearly 600 customers, the movie rental business isn't going anywhere!</p>
                    <p>The only thing Sakila Movie Rentals is missing is you!</p>
                    <p>Come visit us at one of our two convenient locatons!</p>
                </div>
            </div>
        </div>
        <div class="footer">
            <div class="footercontent">
                <p>Patent pending but please don't steal from us while we get out legal shit figured out.</p>
            </div>
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