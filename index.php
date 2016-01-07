<?php //if(!$_SERVER['HTTPS']) header('Location: https://' . $_SERVER['SERVER_NAME']);
  require_once("db.php");
  //$sql = "INSERT INTO __Access (IP, IPproxy) VALUES ('" . $_SERVER['REMOTE_ADDR'] . "','" . $_SERVER['HTTP_X_FORWARDED_FOR'] . "')";
  //if(!mysql_query($sql)) die('authentication failure 1');

if(!((fnmatch("192.168*",$_SERVER["REMOTE_ADDR"])) && 
        ((empty($_SERVER["HTTP_X_FORWARDED_FOR"])) || (fnmatch("192.168*",$_SERVER["HTTP_X_FORWARDED_FOR"]))))){
  $sql = "SELECT IP FROM __AccessList WHERE (IP='" . $_SERVER['HTTP_X_FORWARDED_FOR'] . "') AND flag = 'ok'";
  $result = mysql_query($sql);
  if(!$result) die('authentication failed 2');
  //echo mysql_num_rows($result);
  if(mysql_num_rows($result) < 1){
	//$msg = "the following ip has accessed the system: " . $_SERVER['REMOTE_ADDR'] . ", HTTP_X_FORWARDED_FOR: " . $_SERVER['HTTP_X_FORWARDED_FOR'];
	$msg = date("Y-m-d H:i:s")
        . " NOT local ip: " . $_SERVER["REMOTE_ADDR"]
        . " proxy: " . $_SERVER["HTTP_X_FORWARDED_FOR"];
	$headers = 'From: "movies" <differencebetweengoodandevil@gmail.com>' . "\r\n" .
	   'X-Mailer: PHP/' . phpversion();
	mail("jeffpuckett2@gmail.com", "new visitor" . date("Y-m-d H:i:s"), $msg, $headers);
  }
}

session_start();
if(isset($_GET['logout'])){
    session_destroy();
    header('Location: ' . $_SERVER['SCRIPT_NAME']);
}

include("hash.php");

?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
    <meta name="description" content="">
    <meta name="author" content="">
    <link rel="icon" href="lin_ubuntu.ico">

    <title>Login</title>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.2/jquery.min.js"></script>
<!-- Latest compiled and minified CSS -->
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.4/css/bootstrap.min.css">

<!-- Optional theme -->
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.4/css/bootstrap-theme.min.css">

<!-- Latest compiled and minified JavaScript -->
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.4/js/bootstrap.min.js"></script>

    <!-- Custom styles for this template -->
    <!-- <link href="starter-template.css" rel="stylesheet"> -->

    <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
    <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
      <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
<style>
body {
  padding-top: 65px;
}
//html {
  background: url(ubuntu-echoes.png) no-repeat center center fixed;
  -webkit-background-size: cover;
  -moz-background-size: cover;
  -o-background-size: cover;
  background-size: cover;
}
</style>

  </head>

  <body>

    <nav class="navbar navbar-inverse navbar-fixed-top">
      <div class="container">
        <div class="navbar-header">
          <button id='n' type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
            <span class="sr-only">Toggle navigation</span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
          </button>
        </div>
      <form method="post" class="navbar-form pull-right form-inline">
              <input class="form-control" type="text" name="user" placeholder="Username">
              <input class="form-control" type="password" name="pwd" placeholder="Password">
              <button type="submit" class="btn">Login</button>
      </form>
      </div>
    </nav>

    <div class="container">

      <div class="starter-template">
<!--
 <form class="form-inline" role="form" method="post">
  <div class="form-group">
    <label for="email">Email address:</label>
    <input type="email" class="form-control" id="email" name="email" REQUIRED="TRUE"/>
  </div>
  <div class="form-group">
    <label for="pwd">Password:</label>
    <input type="password" class="form-control" id="pwd" name="pwd"/>
  </div>
  <div class="checkbox">
    <label><input type="checkbox"> Remember me</label>
  </div>
  <button type="submit" class="btn btn-default">Submit</button>
</form>
-->

<img class="img-responsive" style="display: block; margin-left: auto; margin-right: auto;" src="ubuntu-echoes.png" alt="Ubuntu Logo" />

<?php include 'footer.php'; ?>
