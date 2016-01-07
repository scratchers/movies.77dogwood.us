<?php include 'header.php';
require_once("db.php");

// list all movies in database
$sql = "SELECT DISTINCT ID, title, year, fname, released, runtime FROM `Movies` m WHERE 1 ";
if(!$_SESSION['UNRESTRICTED'])
	$sql .= " AND m.restricted = 0 ";

if(isset($_GET["unrestricted"]))
          $sql .= " AND m.restricted = 0 ";
elseif(isset($_GET["restricted"]))
          $sql .= " AND m.restricted = 1 ";

if(isset($_GET["new"]))
          $sql .= " AND m.ID NOT IN (SELECT MovieID FROM `_UserTags` WHERE MovieID = m.ID AND TagID = 1 AND UserID =" .
                  $_SESSION["id"] . ") ";
elseif(isset($_GET["old"]))
          $sql .= " AND m.ID IN (SELECT MovieID FROM `_UserTags` WHERE MovieID = m.ID AND TagID = 1 AND UserID =" .
                  $_SESSION["id"] . ") ";
				  
if(isset($_GET["favorite"]))
          $sql .= " AND m.ID IN (SELECT MovieID FROM `_UserTags` WHERE MovieID = m.ID AND TagID = 2 AND UserID =" .
                  $_SESSION["id"] . ") ";
elseif(isset($_GET["notfavorite"]))
          $sql .= " AND m.ID NOT IN (SELECT MovieID FROM `_UserTags` WHERE MovieID = m.ID AND TagID = 2 AND UserID =" .
                  $_SESSION["id"] . ") ";

if(isset($_GET["unbanned"]))
          $sql .= " AND m.ID NOT IN (SELECT MovieID FROM `_UserTags` WHERE MovieID = m.ID AND TagID = 3 AND UserID =" .
                  $_SESSION["id"] . ") ";
elseif(isset($_GET["banned"]))
          $sql .= " AND m.ID IN (SELECT MovieID FROM `_UserTags` WHERE MovieID = m.ID AND TagID = 3 AND UserID =" .
                  $_SESSION["id"] . ") ";

if(isset($_GET["sortarrival"]))
	$sql .= " ORDER BY ID DESC ";
elseif(isset($_GET["sortyear"]))
	$sql .= " ORDER BY year DESC, released DESC ";
elseif(isset($_GET["sortruntime"]))
	$sql .= " ORDER BY runtime ";
else
	$sql .= " ORDER BY year DESC, released DESC ";

$result = mysql_query($sql);
if (!$result) {
    die('Invalid query: ' . mysql_error());
}

$i = 0;
echo "<div class='row'>";
while ($row = mysql_fetch_assoc($result)) {
	if ($i % 4 == 0) echo "</div><br/><div class='row'>";
?>

	<div class="col-md-3 col-sm-6 col-xs-12">
	  <a href="vid.php?id=<?php echo $row["ID"];?>">
	  <!-- <?php echo "<h3>" . $row["title"] . "</h3>"; ?> -->
<?php
if(isset($_GET["sortarrival"]))
	echo "<h3>" . $row["ID"] . "</h3>";
elseif(isset($_GET["sortyear"]))
	echo "<h3>(" . $row["year"] . ") - " . $row["released"] . "</h3>";
elseif(isset($_GET["sortruntime"]))
	echo "<h3>" . $row["runtime"] . " Minutes</h3>";
?>
	  <img class='img-responsive' src='posters/<?php echo str_replace("'", "&#39;", $row["fname"]); ?>.jpg' alt='<?php echo $row["title"]; ?>' style="margin-top:10px;" />
	  </a>
	</div>
<?php
$i++;}
echo "</div>";

include 'footer.php'; ?>
