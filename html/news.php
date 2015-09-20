<?php
session_start();
if(!$_SESSION["ADMIN"]){
  header('Location: /');
}

include 'header.php';
require_once("db.php");

// insert new record to database
if (isset($_POST['fname']) && isset($_POST['fpath']) && isset($_POST['title'])) {
	$sql = "INSERT INTO Movies (fname, fpath, title, extension";
	if (isset($_POST['restricted'])){
		$sql .= ", restricted";
	}
        if (!empty($_POST['year'])){
                $sql .= ", year";
        }
        if (!empty($_POST['mimetype'])){
                $sql .= ", mimetype";
        }
        if (!empty($_POST['imdbid'])){
                $sql .= ", imdbid";
        }
        if (!empty($_POST['rated'])){
                $sql .= ", rated";
        }
        if (!empty($_POST['released'])){
                $sql .= ", released";
        }
        if (!empty($_POST['runtime'])){
                $sql .= ", runtime";
        }
        if (!empty($_POST['genre'])){
                $sql .= ", genre";
        }
        if (!empty($_POST['director'])){
                $sql .= ", director";
        }
        if (!empty($_POST['writer'])){
                $sql .= ", writer";
        }
        if (!empty($_POST['actors'])){
                $sql .= ", actors";
        }
        if (!empty($_POST['plot'])){
                $sql .= ", plot";
        }
        if (!empty($_POST['language'])){
                $sql .= ", language";
        }
        if (!empty($_POST['country'])){
                $sql .= ", country";
        }
        if (!empty($_POST['awards'])){
                $sql .= ", awards";
        }
	$sql .= ") VALUES ('";
	$sql .= mysql_real_escape_string($_POST['fname']) . "', '" . mysql_real_escape_string($_POST['fpath']) . "', '" . mysql_real_escape_string($_POST['title']) . "', '" . mysql_real_escape_string($_POST['extension']) . "'";
        if (isset($_POST['restricted'])){
                $sql .= ", 1";
        }
        if (!empty($_POST['year'])){
                $sql .= ", " . mysql_real_escape_string($_POST['year']);
        }
        if (!empty($_POST['mimetype'])){
                $sql .= ", '" . mysql_real_escape_string($_POST['mimetype']) . "'";
        }
        if (!empty($_POST['imdbid'])){
                $sql .= ", '" . mysql_real_escape_string($_POST['imdbid']) . "'";
        }
        if (!empty($_POST['rated'])){
                $sql .= ", '" . mysql_real_escape_string($_POST['rated']) . "'";
        }
        if (!empty($_POST['released'])){
                $sql .= ", '" . mysql_real_escape_string($_POST['released']) . "'";
        }
        if (!empty($_POST['runtime'])){
                $sql .= ", '" . mysql_real_escape_string($_POST['runtime']) . "'";
        }
        if (!empty($_POST['genre'])){
                $sql .= ", '" . mysql_real_escape_string($_POST['genre']) . "'";
        }
        if (!empty($_POST['director'])){
                $sql .= ", '" . mysql_real_escape_string($_POST['director']) . "'";
        }
        if (!empty($_POST['writer'])){
                $sql .= ", '" . mysql_real_escape_string($_POST['writer']) . "'";
        }
        if (!empty($_POST['actors'])){
                $sql .= ", '" . mysql_real_escape_string($_POST['actors']) . "'";
        }
        if (!empty($_POST['plot'])){
                $sql .= ", '" . mysql_real_escape_string($_POST['plot']) . "'";
        }
        if (!empty($_POST['language'])){
                $sql .= ", '" . mysql_real_escape_string($_POST['language']) . "'";
        }
        if (!empty($_POST['country'])){
                $sql .= ", '" . mysql_real_escape_string($_POST['country']) . "'";
        }
        if (!empty($_POST['awards'])){
                $sql .= ", '" . mysql_real_escape_string($_POST['awards']) . "'";
        }
	$sql .= ")";
//	echo $sql;
	if (!mysql_query($sql))
		echo mysql_error();
}

// function to search seed directory for movies
$seedDir = "/mnt/popshare/Movies";
function getMovs($dir, $prefix = '') {
  $dir = rtrim($dir, '\\/');
  $extensions = array("mkv", "mp4", "avi", "mov");
  $result = array();

    foreach (scandir($dir) as $f) {
      if ($f !== '.' and $f !== '..') {
        if (is_dir("$dir/$f")) {
          $result = array_merge($result, getMovs("$dir/$f", "$prefix$f/"));
        } else {
		$ext = pathinfo($prefix.$f, PATHINFO_EXTENSION);
		if (in_array($ext,$extensions)){
			$result[] = array("fpath"=>$prefix.$f, "fname"=>$f);}
        }
      }
    }

  return $result;
}

/*
// list all movies in seed directory
echo "<div class='col-md-12'><div class='col-md-6'>";
echo "<h2>movies in seed directory</h2>";
echo "<ol>";
foreach (getMovs($seedDir) as $movie){
        echo "<li>" . $movie["fname"] . "</li>";
}
echo "</ol></div>";

// list all movies in database
$sql = "SELECT * FROM Movies ORDER BY fname";
$result = mysql_query($sql);
if (!$result) {
    die('Invalid query: ' . mysql_error());
}
echo "<div class='col-md-6'>";
echo "<h2>movies in database</h2>";
echo "<ol>";
while ($row = mysql_fetch_assoc($result)) {
        echo "<li>" . $row["title"] . "</li>";
}
echo "</ol></div></div>";
*/


// FIND NEW ITEMS
// select statement to find seed files not in database
//echo "<h2>new seed files not in database select statement</h2>";
$sql = "SELECT * FROM (SELECT 'testname' AS fname, 'testpath' AS fpath ";
foreach (getMovs($seedDir) as $movie){
        $sql .= " UNION SELECT '" . mysql_real_escape_string($movie["fname"]) . "', '" . mysql_real_escape_string($movie["fpath"]) . "'";
}
$sql .= ") AS tmp WHERE tmp.fpath NOT IN (select fpath from Movies UNION select fpath from MovieXtras union select 'testpath')";
//echo $sql;


// new seed files results
$result = mysql_query($sql);
if (!$result) {
    die('Invalid query: ' . mysql_error());
}

$num_rows = mysql_num_rows($result);
if ($num_rows > 1)
	echo "<h2>found " . $num_rows . " new movies to add to database</h2>";
elseif ($num_rows == 1) echo "<h2>found " . $num_rows . " new movie to add to database</h2>";
else echo "<h2>no new movies to add to database</h2>";
//echo "<div class='table-responsive'><table class='table table-striped table-bordered table-condensed'>";
//echo "<thead><tr><th>#</th><th>fname</th><th style='text-align: center;'>Watched</th><th>Title</th><th/></tr></thead>";
//echo "<thead><tr><th>Identity</th><th>Add to Database</th></tr></thead>";
//echo "<tbody>";
//$i = 0;
//while ($row = mysql_fetch_assoc($result)) {
if($row = mysql_fetch_assoc($result)){
/*        echo "<tr><form name='insert'>";
        echo "<input type='hidden' name='fname' value='" . $row["fname"] . "'/>";
        echo "<input type='hidden' name='fpath' value='" . $row["fpath"] . "'/>";
	echo "<td style='text-align: center;'>" . ++$i . "</td>";
	echo "<td>" . $row["fname"] . "</td>";
	echo "<td style='text-align: center; vertical-align: middle;'><input type='checkbox' name='watched' /></td>";
	echo "<td><input name='title' type='text' placeholder='" . $row["fname"] . "' /></td>";
	echo "<td><button>Add</button></td></form></tr>";
*/
?>
<div class='col-md-12' style='border: 1px solid lightgray; padding: 10px;'>
<div class='col-md-4'">
  <?php
	$url = "http://guessit.io/guess?filename=";
	$url .= $row["fname"];
	$guess = json_decode(file_get_contents($url));
//	var_dump($guess);
//	echo $guess->{'title'} . " (" . $guess->{'year'} . ")<br/>";

	$url = "http://www.omdbapi.com/?r=json&t=";
	$url .= urlencode($guess->{'title'});
	$url .= "&y=" . $guess->{'year'};
	$omdb = json_decode(file_get_contents($url));
//	var_dump($omdb);
/*
	$ch = curl_init($omdb->{'Poster'});
	$img = "posters/" . $row["fname"] . ".jpg";
	$fp = fopen($img, "w");

	curl_setopt($ch, CURLOPT_FILE, $fp);
	curl_setopt($ch, CURLOPT_HEADER, 0);

	curl_exec($ch);
	curl_close($ch);
	fclose($fp);
*/

	if(isset($omdb->{'Poster'})){
	  $img = "posters/" . $row["fname"] . ".jpg";
	  $pos = file_get_contents($omdb->{'Poster'});
	  file_put_contents($img, $pos);
	}
	echo "<div style='text-align: center;'><img style='display:block;' id='imgpos' class='img-responsive' src='" . str_replace("'", "&#39;", $img) . "'></img></div>";
  ?>
</div>
<div class='col-md-8'>
  <form name="insert" method="post" class="form-horizontal" role="form">
  <?php
        echo "<input type='hidden' name='fpath' value='" . str_replace("'", "&#39;", $row["fpath"]) . "' READONLY/>";
  ?>
  <div class="form-group">
    <label class="control-label col-sm-2" for="fname">Filename:</label>
    <div class="col-sm-10">
      <input type="text" class="form-control" id="fname" name="fname" value="<?php echo $row['fname']; ?>" READONLY/>
    </div>
  </div>
  <div class="form-group">
    <label class="control-label col-sm-2" for="title">Title:</label>
    <div class="col-sm-10">
      <input type="text" class="form-control" id="title" name="title" value="<?php echo $guess->{'title'}; ?>" REQUIRED/>
    </div>
  </div>
<script>
function om(){
  var omdb = "http://www.omdbapi.com/?r=json";
  if($("#imdbid").val() != ""){
    omdb += "&i=" + encodeURIComponent($("#imdbid").val());
	
  }
  else if($("#title").val() != ""){
    omdb += "&t=" + encodeURIComponent($("#title").val());
    if($("#imdbid").val() != ""){
      omdb += "&y=" + $("#year").val();
    }
  } else {
    alert("Need at least a title with which to search.");
    return;
  }

  //alert("Make sure cross-domain scripting enabled in browser if not working.");
  
  $.getJSON( omdb, function( data ) {

  $("#title").val(data["Title"]);
  $("#genre").val(data["Genre"]);
  $("#plot").val(data["Plot"]);
  $("#rated").val(data["Rated"]);
  $("#released").val($.datepicker.formatDate('yy-mm-dd', new Date(data["Released"])));
  $("#runtime").val(data["Runtime"]);
  $("#director").val(data["Director"]);
  $("#writer").val(data["Writer"]);
  $("#actors").val(data["Actors"]);
  $("#language").val(data["Language"]);
  $("#country").val(data["Country"]);
  $("#awards").val(data["Awards"]);
  $("#imdbid").val(data["imdbID"]);
  $("#genre").val(data["Genre"]);
  $.post( "getposter.php", { fname: "<?php echo $row['fname']; ?>", poster: data['Poster'] } );
  $("#imgpos").attr("src", "posters/<?php echo $row['fname']; ?>.jpg?");

  });
}
</script>
  <div class="form-group">
    <div class="col-sm-offset-2 col-sm-10">
      <a id="omdb" class="btn btn-default" onclick="return om()">Search IMDB</a>
    </div>
  </div>
  <!-- <div class="form-group">
    <div class="col-sm-offset-2 col-sm-10">
      <div id="omajax"></div>
    </div>
  </div> -->
  <div class="form-group">
    <label class="control-label col-sm-2" for="genre">Genre:</a></label>
    <div class="col-sm-10">
      <input type="text" class="form-control" id="genre" name="genre" value="<?php echo $omdb->{'Genre'}; ?>" />
    </div>
  </div>
  <div class="form-group">
    <label class="control-label col-sm-2" for="plot">Plot:</a></label>
    <div class="col-sm-10">
      <textarea class="form-control" id="plot" name="plot" rows="3"><?php echo $omdb->{'Plot'}; ?></textarea>
    </div>
  </div>
  <div class="form-group">
    <label class="control-label col-sm-2" for="rated">Rated:</a></label>
    <div class="col-sm-10">
      <input type="text" class="form-control" id="rated" name="rated" value="<?php echo $omdb->{'Rated'}; ?>" />
    </div>
  </div>
  <div class="form-group">
    <label class="control-label col-sm-2" for="year">Year:</label>
    <div class="col-sm-10">
      <input type="number" class="form-control" id="year" name="year" value="<?php echo $guess->{'year'}; ?>" placeholder="Year of Release Date"/>
    </div>
  </div>
  <div class="form-group">
    <label class="control-label col-sm-2" for="released">Released:</a></label>
    <div class="col-sm-10">
      <input type="text" class="form-control" id="released" name="released" value="<?php echo date("Y-m-d", strtotime($omdb->{'Released'})); ?>" />
    </div>
  </div>
  <div class="form-group">
    <label class="control-label col-sm-2" for="runtime">Runtime:</a></label>
    <div class="col-sm-10">
      <input type="text" class="form-control" id="runtime" name="runtime" value="<?php echo preg_replace("/[^0-9]/","",$omdb->{'Runtime'}); ?>" />
    </div>
  </div>
  <div class="form-group">
    <label class="control-label col-sm-2" for="director">Director:</a></label>
    <div class="col-sm-10">
      <input type="text" class="form-control" id="director" name="director" value="<?php echo $omdb->{'Director'}; ?>" />
    </div>
  </div>
  <div class="form-group">
    <label class="control-label col-sm-2" for="writer">Writer:</a></label>
    <div class="col-sm-10">
      <input type="text" class="form-control" id="writer" name="writer" value="<?php echo $omdb->{'Writer'}; ?>" />
    </div>
  </div>
  <div class="form-group">
    <label class="control-label col-sm-2" for="actors">Actors:</a></label>
    <div class="col-sm-10">
      <input type="text" class="form-control" id="actors" name="actors" value="<?php echo $omdb->{'Actors'}; ?>" />
    </div>
  </div>
  <div class="form-group">
    <label class="control-label col-sm-2" for="language">Language:</a></label>
    <div class="col-sm-10">
      <input type="text" class="form-control" id="language" name="language" value="<?php echo $omdb->{'Language'}; ?>" />
    </div>
  </div>
  <div class="form-group">
    <label class="control-label col-sm-2" for="country">Country:</a></label>
    <div class="col-sm-10">
      <input type="text" class="form-control" id="country" name="country" value="<?php echo $omdb->{'Country'}; ?>" />
    </div>
  </div>
  <div class="form-group">
    <label class="control-label col-sm-2" for="awards">Awards:</a></label>
    <div class="col-sm-10">
      <input type="text" class="form-control" id="awards" name="awards" value="<?php echo $omdb->{'Awards'}; ?>" />
    </div>
  </div>
  <div class="form-group">
    <label class="control-label col-sm-2" for="metascore">Metascore:</a></label>
    <div class="col-sm-10">
      <input type="text" class="form-control" id="metascore" name="metascore" value="<?php echo $omdb->{'Metascore'}; ?>" />
    </div>
  </div>
  <div class="form-group">
    <label class="control-label col-sm-2" for="imdbRating">imdbRating:</a></label>
    <div class="col-sm-10">
      <input type="text" class="form-control" id="imdbRating" name="imdbRating" value="<?php echo $omdb->{'imdbRating'}; ?>" />
    </div>
  </div>
  <div class="form-group">
    <label class="control-label col-sm-2" for="imdbid"><a target="_blank" href="http://www.imdb.com/title/<?php echo $omdb->{'imdbID'}; ?>">IMDBid:</a></label>
    <div class="col-sm-10">
      <input type="text" class="form-control" id="imdbid" name="imdbid" value="<?php echo $omdb->{'imdbID'}; ?>" />
    </div>
  </div>
  <div class="form-group">
    <label class="control-label col-sm-2" for="extension">Extension:</label>
    <div class="col-sm-10">
      <input type="text" class="form-control" id="extension" name="extension" value="<?php echo $guess->{'container'}; ?>" REQUIRED/>
    </div>
  </div>
  <div class="form-group">
    <label class="control-label col-sm-2" for="mimetype">Mimetype:</label>
    <div class="col-sm-10">
      <input type="text" class="form-control" id="mimetype" name="mimetype" value="<?php echo $guess->{'mimetype'}; ?>"/>
    </div>
  </div>
  <div class="form-group">
    <div class="col-sm-offset-2 col-sm-10">
      <div class="checkbox">
        <label><input type="checkbox" name="restricted"> Restricted</label>
      </div>
    </div>
  </div>
  <div class="form-group">
    <div class="col-sm-offset-2 col-sm-10">
      <button type="submit" class="btn btn-default">Add to Database</button>
    </div>
  </div>
  </form>

<!--  <hr/>

  <form action="dlimage.php" name="dlimage" class="form-horizontal" role="form">
  <div class="form-group">
    <label class="control-label col-sm-2" for="poster">Poster:</label>
    <div class="col-sm-10">
      <input type="url" class="form-control" id="poster" name="poster" value="<?php echo $omdb->{'Poster'}; ?>" />
    </div>
  </div>
  <div class="form-group">
    <div class="col-sm-offset-2 col-sm-10">
      <button type="submit" class="btn btn-default">Download Poster</button>
    </div>
  </div>
  </form>
-->

</div></div>
<?php
}
echo "</div>";

/*
// insert statements to add files
$result = mysql_query($sql);
if (!$result) {
    die('Invalid query: ' . mysql_error());
}
echo "<h2>new files insert statements</h2>";
while ($row = mysql_fetch_assoc($result)){
        $sql = "INSERT INTO Movies (title, fname, fpath) VALUES ";
        $sql .= "('" . $row["fname"] . "', '" . $row["fname"] . "', '" . $row["fpath"] . "')";
        echo "<li>" . $sql . "</li>";
}
*/

/*        <embed type="application/x-vlc-plugin"
         name="video1"
         autoplay="no"
         target="http://192.168.0.106/deluge/_seed/Asterix.Le.domaine.des.dieux.2014.mkv" />
*/

include 'footer.php'; ?>
