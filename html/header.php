<?php
if(!$_SERVER['HTTPS'])
    header('Location: https://' . $_SERVER['SERVER_NAME']);
if (session_status() == PHP_SESSION_NONE)
    session_start();
if(!isset($_SESSION['user']))
    header('Location: /');
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
    <link rel="icon" href="Movies.ico">

    <title>Movies</title>

<!-- JQUERY -->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.2/jquery.min.js"></script>
<!-- JQUERY UI -->
<script src="include/jquery-ui.min.js"></script>

<!-- BOOTSTRAP CSS Latest compiled and minified CSS -->
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.4/css/bootstrap.min.css">

<!-- BOOTSTRAP CSS Optional theme -->
<link rel="stylesheet" href="include/bootstrap-theme.min.css">

<!-- BOOTSTRAP JAVASCRIPT Latest compiled and minified JavaScript -->
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.4/js/bootstrap.min.js"></script>

<!-- BROKEN --- BOOTSWITCH TOGGLES FOR CHECKBOXES/RADIO 
<link href="include/bootstrap-switch.css" rel="stylesheet">
<script src="include/bootstrap-switch.js"></script>
<!-- BROKEN --- BOOTSWITCH TOGGLES FOR CHECKBOXES/RADIO -->


    <!-- Custom styles for this template -->
    <!-- <link href="starter-template.css" rel="stylesheet"> -->

    <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
    <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
      <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
<style>
/* PADDING FOR STATIC-FIXED TOP NAV */
body {
    padding-top: 65px;
}

.video-container {
    position: relative;
    padding-bottom: 56.25%;
    padding-top: 30px; height: 0; overflow: hidden;
}

.video-container iframe,
.video-container object,
.video-container embed {
    position: absolute;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
}

/* FILTER */
@media (max-width: 767px) {
	#filter.open {
	  color: white;
	}
}
#filter li {
  margin-left: 10px;
}
#filter .btn {
  margin-top: 5px;
  margin-bottom: 5px;
}
</style>
<script>
// FAVVIEW
function favview(){
  $("#favview").hide();
  //if($("#unrestricted").is(':checked'))
}


// HIGHLIGHT CURRENT MENU ITEM
$(document).ready(function () {
 var page = document.location.href;

 // Set BaseURL
 // var baseURL = 'http://www.example.com/';

 // Get current URL and replace baseURL
 //  var href = window.location.href.replace(baseURL, '');
    var href = window.location.href;

  // Remove trailing slash
  href = href.substr(-1) == '/' ? href.substr(0, href.length - 1) : href;

  // Get last part of current URL
  var page = href.substr(href.lastIndexOf('/') + 1);

  if(page == 'popshare.php'){
      $('#popshare').addClass('active');
  }else{
      $('#vids').removeClass('active');
  }

  if(page == 'watch.php'){
      $('#watch').addClass('active');
  }else{
      $('#vids').removeClass('active');
  }

  if(page == 'news.php'){
      $('#news').addClass('active');
  }else{
      $('#news').removeClass('active');
  }
});
</script>
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
          <a class="navbar-brand" style="text-shadow: gray 0.1em 0.1em 0.2em" href="vids.php<?php echo $_SESSION['fav']; ?>">Movies</a>
        </div>
        <div id="navbar" class="collapse navbar-collapse">
          <ul class="nav navbar-nav">

<!-- DROPDOWN FILTER NAV -->
<li id="filter" class="dropdown">
  <a aria-expanded="true" href="#" class="dropdown-toggle" data-toggle="dropdown">Filter</a>
    <ul class="dropdown-menu">
      <form action="vids.php" role="form" id="formFilter">
		<?php
			if($_SESSION['UNRESTRICTED']){ ?>
				<li><label class='checkbox-inline'>
				  <input class='checkbox-filter' onclick='favview(); $("#unrestricted").prop("checked", false);' type='checkbox' name='restricted' id='restricted' <?php if(isset($_GET["restricted"])) echo "checked='true'";?> >GrownUp</input></label></li>
				<li><label class='checkbox-inline'>
				  <input class='checkbox-filter' onclick='favview(); $("#restricted").prop("checked", false);' type='checkbox' name='unrestricted' id='unrestricted' <?php if(isset($_GET["unrestricted"])) echo "checked='true'";?>  >Family</input></label></li>
			<?php } 
		?>
        <li><label class='checkbox-inline'>
		  <input class='checkbox-filter' onclick='favview(); $("#old").prop("checked", false);' type='checkbox' name='new' id='new' <?php if(isset($_GET["new"])) echo "checked='true'";?>  >New</input></label></li>
		<li><label class='checkbox-inline'>
		  <input class='checkbox-filter' onclick='favview(); $("#new").prop("checked", false);' type='checkbox' name='old' id='old' <?php if(isset($_GET["old"])) echo "checked='true'";?>  >Old</input></label></li>
		<li><label class='checkbox-inline'>
		  <input class='checkbox-filter' onclick='favview(); $("#unbanned").prop("checked", false);' type='checkbox' name='banned' id='banned' <?php if(isset($_GET["banned"])) echo "checked='true'";?>  >Banned</input></label></li>
		<li><label class='checkbox-inline'>
		  <input class='checkbox-filter' onclick='favview(); $("#banned").prop("checked", false);' type='checkbox' name='unbanned' id='unbanned' <?php if(isset($_GET["unbanned"])) echo "checked='true'";?>  >UnBanned</input></label></li>
		<li><label class='checkbox-inline'>
		  <input class='checkbox-filter' onclick='favview(); $("#notfavorite").prop("checked", false);' type='checkbox' name='favorite' id='favorite' <?php if(isset($_GET["favorite"])) echo "checked='true'";?>  >Favorite</input></label></li>
		<li><label class='checkbox-inline'>
		  <input class='checkbox-filter' onclick='favview(); $("#favorite").prop("checked", false);' type='checkbox' name='notfavorite' id='notfavorite' <?php if(isset($_GET["notfavorite"])) echo "checked='true'";?>  >NotFavorite</input></label></li>
	<li><a class="btn btn-default" onclick='favview(); $(".checkbox-filter:checkbox").removeAttr("checked");'>UnCheck All</a></li>
        <li><button class="btn btn-primary">Filter</button></li>
		<li>
		 <?php if($_SERVER["SCRIPT_NAME"] == "vids.php"){ ?>
		  <a id='favview' href='favview.php?<?php echo http_build_query($_GET); ?>' class='btn btn-success'>Make Homepage</a>
		 <?php } ?>
		</li>

    </ul>
</li>
<!-- END DROPDOWN FILTER NAV -->

<!-- DROPDOWN SORT NAV -->
<script>
function sortClick(chbx){
  $(".checkbox-sort:checkbox").removeAttr("checked");
  $(chbx).prop("checked", true);
  $("#formFilter").submit();
}
</script>
<li id="filter" class="dropdown">
  <a aria-expanded="true" href="#" class="dropdown-toggle" data-toggle="dropdown">Sort</a>
  <ul class="dropdown-menu">
	<li><label class='checkbox-inline'>
		  <input class='checkbox-sort' onclick='sortClick(this);' type='checkbox' name='sortyear' id='sortyear' <?php if(isset($_GET["sortyear"])) echo "checked='true'";?>  >Release Date</input></label></li>
	<li><label class='checkbox-inline'>
		  <input class='checkbox-sort' onclick='sortClick(this);' type='checkbox' name='sortruntime' id='sortruntime' <?php if(isset($_GET["sortruntime"])) echo "checked='true'";?>  >Run Time</input></label></li>
	<li><label class='checkbox-inline'>
		  <input class='checkbox-sort' onclick='sortClick(this);' type='checkbox' name='sortarrival' id='sortarrival' <?php if(isset($_GET["sortarrival"])) echo "checked='true'";?>  >Downloaded</input></label></li>
	<li><label class='checkbox-inline'>
		  <input class='checkbox-sort' onclick='sortClick(this);' type='checkbox' name='sortnone' id='sortnone' <?php if(isset($_GET["sortnone"])) echo "checked='true'";?>  >None</input></label></li>
  </ul>
</li>
<!-- END DROPDOWN SORT NAV -->
      </form>

	<?php if($_SESSION["ADMIN"]){ ?>
	    <li id="popcorn"><a target="_blank" href="https://tls.passthepopcorn.me/torrents.php?action=advanced&freetorrent=1">Popcorn</a></li>
            <li id="news"><a href="news.php">News</a></li>
            <li id="popshare"><a href="popshare.php">Network</a></li>
            <li id="watch"><a href="watch.php">Watch</a></li>
            <li id="deluge"><a href="http://<?php echo $_SERVER['SERVER_NAME']; ?>:8112" target="_blank">Deluge</a></li>
	    <li id="phpMyAdmin"><a href="phpmyadmin/" target="_blank">phpMyAdmin</a></li>
	    <li id="ip"><a href="ip.php">IP</a></li>
        <?php } ?>
           </ul>
	   <div class="pull-right">
		<ul class="nav navbar-nav">
	      <li id="logout"><a href="index.php?logout">Logout <?php echo " " . strtoupper($_SESSION['user']); ?></a></li>
		</ul>
	   </div>
        </div><!--/.nav-collapse -->
      </div>
    </nav>

    <div class="container">

      <div class="starter-template">

