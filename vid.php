<?php 

if(!is_numeric($_GET["id"]))
  header('Location: /');

include 'header.php';

require_once("db.php");
$id =  mysql_real_escape_string($_GET["id"]);

if($_GET["watched"] === '1')
  $sql = "INSERT INTO _UserTags (UserID,TagID,MovieID) " .
	 "VALUES (" .
	 $_SESSION['id'] . "," .
	 "1," .
	 $id . ")";
else if($_GET["watched"] ==='0')
	$sql = "DELETE FROM _UserTags " .
		" WHERE UserID=" . $_SESSION['id'] .
		" AND MovieID = " . $id .
		" AND TagID = 1";
if($_GET["starred"] === '1')
  $sql = "INSERT INTO _UserTags (UserID,TagID,MovieID) " .
         "VALUES (" .
         $_SESSION['id'] . "," .
         "2," .
         $id . ")";
else if($_GET["starred"] ==='0')
        $sql = "DELETE FROM _UserTags " .
                " WHERE UserID=" . $_SESSION['id'] .
                " AND MovieID = " . $id .
                " AND TagID = 2";
if($_GET["banned"] === '1')
  $sql = "INSERT INTO _UserTags (UserID,TagID,MovieID) " .
         "VALUES (" .
         $_SESSION['id'] . "," .
         "3," .
         $id . ")";
else if($_GET["banned"] ==='0')
        $sql = "DELETE FROM _UserTags " .
                " WHERE UserID=" . $_SESSION['id'] .
                " AND MovieID = " . $id .
                " AND TagID = 3";

if(isset($sql)){
  //echo "sql set: " . $sql;
  $result = mysql_query($sql);
  if (!$result) {
    die('Invalid query: ' . mysql_error());
  }
}

if (isset($_POST['title']) && is_numeric($_POST['id'])) {
	$sql = "UPDATE Movies SET title='" . mysql_real_escape_string($_POST['title'])  . "' ";
        if (!empty($_POST['plot'])){
                $sql .= ", plot='" . mysql_real_escape_string($_POST['plot'])  . "' ";
        }
        if (!empty($_POST['genre'])){
                $sql .= ", genre='" . mysql_real_escape_string($_POST['genre'])  . "' ";
        }
	if (isset($_POST['title'])){
		$sql .= ", title='" . mysql_real_escape_string($_POST['title'])  . "' ";
	}
        if (!empty($_POST['rated'])){
                $sql .= ", rated='" . mysql_real_escape_string($_POST['rated'])  . "' ";
        }
        if (!empty($_POST['year'])){
                $sql .= ", year='" . mysql_real_escape_string($_POST['year'])  . "' ";
        }
        if (isset($_POST['released'])){
                $sql .= ", released='" . mysql_real_escape_string($_POST['released'])  . "' ";
        }
        if (!empty($_POST['runtime'])){
                $sql .= ", runtime='" . mysql_real_escape_string($_POST['runtime'])  . "' ";
        }
        if (!empty($_POST['director'])){
                $sql .= ", director='" . mysql_real_escape_string($_POST['director'])  . "' ";
        }
        if (isset($_POST['writer'])){
                $sql .= ", writer='" . mysql_real_escape_string($_POST['writer'])  . "' ";
        }
        if (!empty($_POST['actors'])){
                $sql .= ", actors='" . mysql_real_escape_string($_POST['actors'])  . "' ";
        }
        if (!empty($_POST['language'])){
                $sql .= ", language='" . mysql_real_escape_string($_POST['language'])  . "' ";
        }
        if (isset($_POST['country'])){
                $sql .= ", country='" . mysql_real_escape_string($_POST['country'])  . "' ";
        }
        if (isset($_POST['awards'])){
                $sql .= ", awards='" . mysql_real_escape_string($_POST['awards'])  . "' ";
        }
        if (!empty($_POST['imdbid'])){
                $sql .= ", imdbid='" . mysql_real_escape_string($_POST['imdbid'])  . "' ";
        }
        if (!empty($_POST['extension'])){
                $sql .= ", extension='" . mysql_real_escape_string($_POST['extension'])  . "' ";
        }
        if (isset($_POST['mimetype'])){
                $sql .= ", mimetype='" . mysql_real_escape_string($_POST['mimetype'])  . "' ";
        }
	if (isset($_POST['restricted'])){
		$sql .= ", restricted=1 ";
	} else $sql .= ", restricted=0 ";

	$sql .= " WHERE ID='" . $_POST['id'] . "'";

	if (!mysql_query($sql)) {
	    die('Invalid query: ' . mysql_error());
	}

}

// GET MOVIE METADATA FROM DATABASE
$sql = "SELECT * FROM Movies WHERE id=" . $id;
//echo $sql;
$result = mysql_query($sql);
if (!$result) {
    die('Invalid query: ' . mysql_error());
}
$i = 0;
echo "<div class='row'>";
while ($row = mysql_fetch_assoc($result)) {
	echo "<div class='col-md-4'><h2>" . $row["title"] . " (" . $row["year"] . ")</h2></div>";

	// TAG CONTROLS
	?>
	<style>
	#editControls .btn {
	    margin: 5px;
	}
	</style>
	<div id='editControls' class='col-md-8'><br>
<?php
        $sql = "SELECT TagID FROM _UserTags WHERE UserID=" . $_SESSION['id'] .
                " AND MovieID =" . $id;
        $tags = mysql_query($sql);
        if (!$tags) {
            die('Invalid query: ' . mysql_error());
        }
        while ($tag = mysql_fetch_assoc($tags)) {
          if($tag['TagID'] == 1)
            $watched = True;
          if($tag['TagID'] == 2)
            $starred = True;
          if($tag['TagID'] == 3)
            $banned = True;

        }
        if($watched)
          echo "<a href='?id=" . $row['ID'] . "&watched=0' class='btn btn-default'>Watched</a>";
        else echo "<a href='?id=" . $row['ID'] . "&watched=1' class='btn btn-success'>New</a>";
        if($starred)
          echo "<a href='?id=" . $row['ID'] . "&starred=0' class='btn btn-success'>Favorite!</a>";
        else echo "<a href='?id=" . $row['ID'] . "&starred=1' class='btn btn-default'>Add to Favorites</a>";
        if($banned)
          echo "<a href='?id=" . $row['ID'] . "&banned=0' class='btn btn-danger'>Banned</a>";
        else echo "<a href='?id=" . $row['ID'] . "&banned=1' class='btn btn-default'>Ban</a>";

	// EDIT BUTTON
	if(isset($_SESSION['ADMIN'])){
	  if($_SESSION['ADMIN'] == "EDIT")
	    echo "<a href='editmode.php' class='btn btn-danger'>Editing</a>";
	  else
	    echo "<a href='editmode.php' class='btn btn-default'>Edit</a>";
	}

	echo "<br/><br/></div>";
	echo "</div>";
?>

<!-- BEGIN MOVIE POSTER/TRAILER ROW --><div class="row">

<!--- BEGIN POSTER COLUMN ---><div class="col-xs-4">
<?php include('poster.php');?>
</div><!--- END POSTER COLUMN --->

<!--- BEGIN TRAILER COLUMN --->
<div class="col-xs-8">
<script>
var vidid = "";
      // 3. This function creates an <iframe> (and YouTube player)
      //    after the API code downloads.
      var player;
      function onYouTubeIframeAPIReady() {
        player = new YT.Player('player', {
          //height: '390', // '390',
          //width: '250', //'640',
          videoId: vidid,
          events: {
            'onReady': stopVideo, //onPlayerReady,
            'onStateChange': onPlayerStateChange
          }
        });
      }

      // 4. The API will call this function when the video player is ready.
      function onPlayerReady(event) {
        event.target.playVideo();
      }

      // 5. The API calls this function when the player's state changes.
      //    The function indicates that when playing a video (state=1),
      //    the player should play for six seconds and then stop.
      var done = false;
      function onPlayerStateChange(event) {
        if (event.data == YT.PlayerState.PLAYING && !done) {
          setTimeout(stopVideo, 6000);
          done = true;
        }
      }
      function stopVideo() {
        player.stopVideo();
      }

$(function(){
$.ajax({
                url : 'https://www.googleapis.com/youtube/v3/search?part=snippet&maxResults=1&key=AIzaSyAGNC8g_IQfGfTL8AowluZBwhJHMtPSGOo&q=<?php echo urlencode($row["title"] . " (" . $row["year"] . ")");?>+movie+trailer',
                type : 'GET',
                dataType : 'json',
                success : function (data)
                {
		    vidid = data.items[0].id.videoId;

		      // 2. This code loads the IFrame Player API code asynchronously.
		      var tag = document.createElement('script');
		      tag.src = "https://www.youtube.com/iframe_api";
		      var firstScriptTag = document.getElementsByTagName('script')[0];
		      firstScriptTag.parentNode.insertBefore(tag, firstScriptTag);

                },
                error: function( xhr, status, errorThrown ) {
                  alert( "Sorry, there was a problem!" );
                console.log( "Error: " + errorThrown );
                console.log( "Status: " + status );
                console.dir( xhr );
                }
            });
});
</script>
<div class="video-container"><div id="player"></div></div>
</div><!--- END TRAILER COLUMN --->
</div><!-- END MOVIE POSTER/TRAILER ROW -->

<br/>

<!-- BEGIN VIDEO PLAYERS/METADATA ROW -->
<div class="row">

<!-- BEGIN VIDEO COLUMN -->
<div id="videoCol" class="col-md-3">

<!--- BEGIN MOVIE EXTRAS CONTROLS --->
<script>
function refreshPlayers(movXfpath){
   $("#vlc-embed").attr("target","/popshare/Movies/" + movXfpath);
   $("#html5video").attr("src","/popshare/Movies/" + movXfpath);
   $("#vlcxspf").attr("href","/xspf.php?fpath=" + movXfpath);
   $("#directDL").attr("href","/popshare/Movies/" + movXfpath);
   var container = document.getElementById("moviePlayers");
   var content = container.innerHTML;
   container.innerHTML= content;
}
</script>
<?php
$sql = "SELECT * FROM MovieXtras WHERE MovieID=" . $id;
//echo $sql;
$movXtras = mysql_query($sql);
if (!$movXtras) {
    die('Invalid query: ' . mysql_error());
}
while ($movXtra = mysql_fetch_assoc($movXtras)) {
?>
	<div class='movExtra'>
	  <a class='btn btn-default' style='margin: 15px;' onclick='refreshPlayers("<?php echo str_replace("'", "&#39;", $movXtra["fpath"]); ?>");'>
	    Load <?php echo $movXtra["description"]; ?>
	  </a>
	</div>
<?php
}
?>
<!--- END MOVIE EXTRAS CONTROLS --->

<!--- BEGIN MOVIE PLAYERS --->
<div id="moviePlayers">

<!---- BEGIN HTML5 VIDEO PLAYER ---->
  <div class="embed-responsive embed-responsive-16by9">
  <video width="320" height="240" controls>
    <!-- <source src="/popshare/Movies/<?php echo $row["fpath"]; ?>" type="<?php echo $row["mimetype"]; ?> codecs='h.264, ac3'"> -->
    <source id ="html5video" src="/popshare/Movies/<?php echo $row["fpath"]; ?>"></source>
    Your browser does not support the video tag.
  </video>
  </div>
<!---- END HTML5 VIDEO PLAYER ---->

  <br/>

<!---- BEGIN VLC EMBED ---->
  <a class="btn btn-default" onclick='$("#vlc-embed-div").toggle();'>Show VLC Embed</a>
  <div id="vlc-embed-div" class="embed-responsive embed-responsive-16by9">
  <embed type="application/x-vlc-plugin"
         id = "vlc-embed"
         autoplay="no"
         target="/popshare/Movies/<?php echo $row["fpath"]; ?>">
  </embed>
  </div>
  <script>$("#vlc-embed-div").hide();</script>
<!---- END VLC EMBED ---->

<!---- BEGIN VLC PLAYLIST XSPF DOWNLOAD ---->
  <a id="vlcxspf" target='_blank' href='/xspf.php?fpath=<?php echo str_replace("'", "&#39;", $row["fpath"]); ?>'><img class='img-responsive' src='vlc.png'/></a>
<!---- END VLC PLAYLIST XSPF DOWNLOAD ---->

<!---- BEGIN DIRECT DOWNLOAD LINK ---->
  <a id="directDL" target='_blank' class='btn btn-default' href='/popshare/Movies/<?php echo str_replace("'", "&#39;", $row["fpath"]); ?>'>Direct Link</a>
<!---- END DIRECT DOWNLOAD LINK ---->

</div><!--- END MOVIE PLAYERS --->
</div><!-- END VIDEO COLUMN -->

<!-- BEGIN MOVIE METADATA COLUMN -->
<div class='col-md-9'>

<?php include('vidmetadata.php');?>

</div><!-- END MOVIE METADATA COLUMN -->
</div><!-- END VIDEO PLAYERS/METADATA ROW -->

<?php
}

include 'footer.php'; ?>
