<?php
// declare database variables
$username = "";
$password = "";
$hostname = "";
$database = "";
// overwrite these variables in a file at a safe location
require_once("/var/www/movies.77dogwood.us/dbcreds.php");

//connection to the database
$dbhandle = mysql_connect($hostname, $username, $password)
  or die("Unable to connect to MySQL");

//select a database to work with
$selected = mysql_select_db($database,$dbhandle)
  or die("Could not select database");
?>
