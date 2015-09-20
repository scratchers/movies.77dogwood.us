<?php
if(!$_SERVER['HTTPS'])
    header('Location: https://' . $_SERVER['SERVER_NAME']);
if (session_status() == PHP_SESSION_NONE)
    session_start();
if(!$_SESSION["ADMIN"])
    die("Administrator Authentication Failure");

if($_SESSION['ADMIN'] == "EDIT")
    $_SESSION['ADMIN'] = "OFF";
else
    $_SESSION['ADMIN'] = "EDIT";

header('Location: ' . $_SERVER['HTTP_REFERER']);
?>
