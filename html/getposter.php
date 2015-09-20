<?php
if(!$_SERVER['HTTPS'])
    header('Location: https://' . $_SERVER['SERVER_NAME']);
if (session_status() == PHP_SESSION_NONE)
    session_start();
if(!isset($_SESSION['user']))
    header('Location: /');
if(!$_SESSION["ADMIN"])
    die("Administrator Authentication Failure");

if(isset($_POST["fname"]) && isset($_POST["poster"])){
	$img = "posters/" . $_POST["fname"] . ".jpg";
	$pos = file_get_contents($_POST["poster"]);
	file_put_contents($img, $pos);
}
?>
