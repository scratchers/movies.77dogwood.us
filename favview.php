<?php session_start();

if (is_numeric($_SESSION['id'])){

  require_once("db.php");

  $sql = "UPDATE _Users SET Fav = '";
  
  $fav .= "?" . $_SERVER["QUERY_STRING"];
  
  $sql .= $fav . "' WHERE ID = " . $_SESSION['id'];

  if (!mysql_query($sql)) {
      die('Invalid query: ' . mysql_error());
  }
  else {
	$_SESSION['fav'] = $fav;
  }
}
header('Location: /'. $_SESSION['fav']);
?>
