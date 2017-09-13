<html lang="en-US">
<head>
<title><?php echo "Sakila - " . ucwords( implode(" ", explode("_", $_GET['table']) ) );?></title>
</head>
<body>

<?php
include('baseController.php');
$bc = new baseController();
$config = include('/var/www/config.php');

echo '<link rel="stylesheet" href="CSS/main.css" type="text/css">';
echo '<div id="outer">';
echo '<div id="sidebar">';
echo '<h1>Sakila Database</h1>';
echo '<p><i>Where people on the internet get movies...</i></p>';
echo '</br></br><p>Check out our fabulous collection of movies and eerily detailed log of customers, rentals and other fun things!</p>';
echo $bc->get_table_dropdown();
echo '</br></br><h3>What our customers have to say:</h3>';
echo '<p>I had no idea they were tracking so much information about me. How do they even know my address?</p>';
echo '<p><i>Virginia Green</i></p>';
echo '</br><p>I live in Brazil and your nearest location is in Canada. Please take me off your mailing list.</p>';
echo '<p><i>Timothy Bunn</i></p>';
echo '</div>';
echo '<div id="content"><h1>' . ucwords( implode(" ", explode("_", $_GET['table']) ) ) . '</h1></br></br>';

if( ! $filter = $bc->get_filter_dropdown($_GET['table']) ){
	return;
}
echo $filter;
$query = "SELECT * FROM " . $_GET['table'] . " limit 10";
if( ! $table = $bc->query($query) ){
	return;
}
echo $bc->get_table($table, true);
echo '</div></div>';
?>
</body>
</html>
