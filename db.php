<?php
// declare database variables
$username = "movies_dev_user";
$password = "p@55W0rd";
$hostname = "localhost";
$database = "movies_dev";

// overrides
$credentials_local = (__DIR__) . "/credentials.local.inc.php";
if (file_exists($credentials_local)) require_once($credentials_local);

//connection to the database
$dbhandle = mysql_connect($hostname, $username, $password)
  or die("Unable to connect to MySQL");

//select a database to work with
$selected = mysql_select_db($database,$dbhandle)
  or die("Could not select database");
?>
