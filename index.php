<?php
include('baseController.php');
echo '<link rel="stylesheet" href="CSS/main.css" type="text/css">';
echo '</br></br><h1>Sakila Database</h1></br>';
$bc = new baseController();
echo $bc->get_table_dropdown();
echo "<h1><a href=\"boots/about.php\">BOOTS</h1>";
/*
$config = include('/var/www/config.php');
$mysqli = new mysqli($config["host"], $config["username"], $config["password"], $config["database"]);
if ($mysqli->connect_errno) {
    printf("Connect failed: %s\n", $mysqli->connect_error);
    exit();
}
$tables = array();
if ($result = $mysqli->query("show tables;")) {
    while( $row = $result->fetch_assoc() ){
        array_push($tables, $row['Tables_in_sakila']);
    }
    $result->close();
}
echo '</br></br><h1>Sakila Databse</h1></br><form action="/table.php" method="get"><select name="table">';
foreach( $tables as $table ) {
    echo '<option value="' . $table . '">'. ucwords( implode(" ", explode("_", $table) ) ) . '</option>';
}
echo '</select></br></br><input type="submit" value="Submit"></input></form>';

*/