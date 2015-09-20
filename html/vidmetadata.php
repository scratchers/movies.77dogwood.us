<?php
if(!$_SERVER['HTTPS'])
    header('Location: https://' . $_SERVER['SERVER_NAME']);
if (session_status() == PHP_SESSION_NONE)
    session_start();
if(!isset($_SESSION['user']))
    header('Location: /');

// NEED TO INCLUDE FROM: if($row = mysql_fetch_assoc($result)){
?>

<script>
function guessit(){
	//alert("Make sure cross-domain scripting enabled in browser if not working.");
	var guess = "http://guessit.io/guess?filename=<?php echo $row['fname'];?>";

	$.getJSON( guess, function( data ) {
		
	var out = "";
	$.each(data, function(key, val) {
        out += "<li>" + key + ": " + val + "</li>";  
    });

     $("#guessitdump").append( out );

  $("#title").val(data["title"]).css( "background-color", "lightgreen" );
  $("#year").val(data["year"]).css( "background-color", "lightgreen" );
  $("#audioCodec").val(data["audioCodec"]).css( "background-color", "lightgreen" );
  $("#videoCodec").val(data["videoCodec"]).css( "background-color", "lightgreen" );
  $("#extension").val(data["container"]).css( "background-color", "lightgreen" );
  $("#mimetype").val(data["mimetype"]).css( "background-color", "lightgreen" );
  
  });
}
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

  alert("Make sure cross-domain scripting enabled in browser if not working.");
  
  $.getJSON( omdb, function( data ) {
  
  	var out = "";
	$.each(data, function(key, val) {
        out += "<li>" + key + ": " + val + "</li>";  
    });

    $("#imdbdump").append( out );
  
  $("#title").val(data["Title"]).css( "background-color", "#FFFF00" );
  $("#genre").val(data["Genre"]).css( "background-color", "#FFFF00" );
  $("#plot").val(data["Plot"]).css( "background-color", "#FFFF00" );
  $("#rated").val(data["Rated"]).css( "background-color", "#FFFF00" );
  $("#released").val($.datepicker.formatDate('yy-mm-dd', new Date(data["Released"]))).css( "background-color", "#FFFF00" );
  $("#runtime").val(data["Runtime"]).css( "background-color", "#FFFF00" );
  $("#director").val(data["Director"]).css( "background-color", "#FFFF00" );
  $("#writer").val(data["Writer"]).css( "background-color", "#FFFF00" );
  $("#actors").val(data["Actors"]).css( "background-color", "#FFFF00" );
  $("#language").val(data["Language"]).css( "background-color", "#FFFF00" );
  $("#country").val(data["Country"]).css( "background-color", "#FFFF00" );
  $("#awards").val(data["Awards"]).css( "background-color", "#FFFF00" );
  $("#imdbid").val(data["imdbID"]).css( "background-color", "#FFFF00" );
  $("#genre").val(data["Genre"]).css( "background-color", "#FFFF00" );
  //$.post( "getposter.php", { fname: "<?php echo $row['fname']; ?>", poster: data['Poster'] } );
  //$("#imgpos").attr("src", "posters/<?php echo $row['fname']; ?>.jpg?");
  
  });
}
</script>

<div id="vidmetadata">
  <form action="?id=<?php echo $row['ID'] ;?>" method="post" class="form-horizontal" role="form">
<?php if($_SESSION["ADMIN"] == "EDIT") {?>
  <div class="form-group">
    <label class="control-label col-sm-2" for="id">ID:</label>
    <div class="col-sm-10">
      <input type="number" class="form-control" id="id" name="id" value="<?php echo $row['ID']; ?>" READONLY/>
    </div>
  </div>
  <div class="form-group">
    <label class="control-label col-sm-2" for="fname">Filename:</label>
    <div class="col-sm-10">
      <input type="text" class="form-control" id="fname" name="fname" value="<?php echo $row['fname']; ?>" READONLY/>
    </div>
  </div>
  <div class="form-group">
    <label class="control-label col-sm-2" for="fpath">FilePath:</label>
    <div class="col-sm-10">
      <input type="text" class="form-control" id="fpath" name="fpath" value="<?php echo $row['fpath']; ?>" READONLY/>
    </div>
  </div>

<?php if($_SESSION["ADMIN"] == "EDIT"){ ?>
  <div class="form-group">
    <div class="col-sm-offset-2 col-sm-10">
      <a id="guessitbtn" class="btn btn-default" onclick="return guessit();">Guess It</a>
	  <a id="guessitdumpbtn" class="btn btn-default" onclick='$("#guessitdump").toggle();'>Show Data</a>
    </div>
  </div>
  <div class="form-group">
    <div class="col-sm-offset-2 col-sm-10">
	  <div id="guessitdump"></div>
    </div>
  </div>
<?php } ?>
  
  <div class="form-group">
    <label class="control-label col-sm-2" for="extension">Extension:</label>
    <div class="col-sm-10">
      <input type="text" class="form-control" id="extension" name="extension" value="<?php echo $row['extension']; ?>" REQUIRED/>
    </div>
  </div>
  <div class="form-group">
    <label class="control-label col-sm-2" for="mimetype">Mimetype:</label>
    <div class="col-sm-10">
      <input type="text" class="form-control" id="mimetype" name="mimetype" value="<?php echo $row['mimetype']; ?>"/>
    </div>
  </div>
  <div class="form-group">
    <label class="control-label col-sm-2" for="audioCodec">Audio Codec:</label>
    <div class="col-sm-10">
      <input type="text" class="form-control" id="audioCodec" name="audioCodec" value="<?php echo $row['audioCodec']; ?>"/>
    </div>
  </div>
  <div class="form-group">
    <label class="control-label col-sm-2" for="videoCodec">Video Codec:</label>
    <div class="col-sm-10">
      <input type="text" class="form-control" id="videoCodec" name="videoCodec" value="<?php echo $row['videoCodec']; ?>"/>
    </div>
  </div>
  <div class="form-group">
    <label class="control-label col-sm-2" for="title">Title:</label>
    <div class="col-sm-10">
      <input type="text" class="form-control" id="title" name="title" value="<?php echo $row['title']; ?>" REQUIRED/>
    </div>
  </div>
<?php } ?>

  <div class="form-group">
    <label class="control-label col-sm-2" for="plot">Plot:</a></label>
    <div class="col-sm-10">
      <textarea class="form-control" id="plot" name="plot" rows="3"><?php echo $row['plot']; ?></textarea>
    </div>
  </div>

<?php if($_SESSION["UNRESTRICTED"]){ ?>
  <div class="form-group">
    <div class="col-sm-offset-2 col-sm-10">
      <div class="checkbox">
        <label <?php if($row['restricted'] == 1) {?> style="color:red;" <?php } ?>><input type="checkbox" name="restricted" <?php if($row['restricted'] == 1){ ?>checked="checked"<?php }?><?php if($_SESSION["ADMIN"] != "EDIT") {?> disabled="true" <?php } ?>> Restricted</label>
      </div>
    </div>
  </div>
<?php } ?>

  <div class="form-group">
    <label class="control-label col-sm-2" for="genre">Genre:</a></label>
    <div class="col-sm-10">
      <input type="text" class="form-control" id="genre" name="genre" value="<?php echo $row['genre']; ?>" />
    </div>
  </div>

  <div class="form-group">
    <label class="control-label col-sm-2" for="rated">Rated:</a></label>
    <div class="col-sm-10">
      <input type="text" class="form-control" id="rated" name="rated" value="<?php echo $row['rated']; ?>" />
    </div>
  </div>

  <div class="form-group">
    <label class="control-label col-sm-2" for="imdbid"><a target="_blank" href="http://www.imdb.com/title/<?php echo $row['imdbid']; ?>">IMDBid:</a></label>
    <div class="col-sm-10">
      <input type="text" class="form-control" id="imdbid" name="imdbid" value="<?php echo $row['imdbid']; ?>" />
    </div>
  </div>

<?php if($_SESSION["ADMIN"] == "EDIT") {?>
  <div class="form-group">
    <div class="col-sm-offset-2 col-sm-10">
      <a id="omdb" class="btn btn-default" onclick="return om()">Search IMDB</a>
	  <a id="imdbdumpbtn" class="btn btn-default" onclick='$("#imdbdump").toggle();'>Show Data</a>
    </div>
  </div>
  <div class="form-group">
    <div class="col-sm-offset-2 col-sm-10">
	  <div id="imdbdump"></div>
    </div>
  </div>
<?php } ?>

  <div class="form-group">
    <label class="control-label col-sm-2" for="runtime">Runtime:</a></label>
    <div class="col-sm-10">
      <input type="text" class="form-control" id="runtime" name="runtime" value="<?php echo $row['runtime']; ?>" />
    </div>
  </div>

<?php if($_SESSION["ADMIN"] == "EDIT") {?>
  <div class="form-group">
    <label class="control-label col-sm-2" for="year">Year:</label>
    <div class="col-sm-10">
      <input type="number" class="form-control" id="year" name="year" value="<?php echo $row['year']; ?>" placeholder="Year of Release"/>
    </div>
  </div>
<?php } ?>

  <div class="form-group">
    <label class="control-label col-sm-2" for="released">Released:</a></label>
    <div class="col-sm-10">
      <input type="text" class="form-control" id="released" name="released" value="<?php echo $row['released']; ?>" />
    </div>
  </div>

  <div class="form-group">
    <label class="control-label col-sm-2" for="awards">Awards:</a></label>
    <div class="col-sm-10">
      <input type="text" class="form-control" id="awards" name="awards" value="<?php echo $row['awards']; ?>" />
    </div>
  </div>

  <div class="form-group">
    <label class="control-label col-sm-2" for="director">Director:</a></label>
    <div class="col-sm-10">
      <input type="text" class="form-control" id="director" name="director" value="<?php echo $row['director']; ?>" />
    </div>
  </div>
  <div class="form-group">
    <label class="control-label col-sm-2" for="writer">Writer:</a></label>
    <div class="col-sm-10">
      <input type="text" class="form-control" id="writer" name="writer" value="<?php echo $row['writer']; ?>" />
    </div>
  </div>
  <div class="form-group">
    <label class="control-label col-sm-2" for="actors">Actors:</a></label>
    <div class="col-sm-10">
      <input type="text" class="form-control" id="actors" name="actors" value="<?php echo $row['actors']; ?>" />
    </div>
  </div>
  <div class="form-group">
    <label class="control-label col-sm-2" for="language">Language:</a></label>
    <div class="col-sm-10">
      <input type="text" class="form-control" id="language" name="language" value="<?php echo $row['language']; ?>" />
    </div>
  </div>
  <div class="form-group">
    <label class="control-label col-sm-2" for="country">Country:</a></label>
    <div class="col-sm-10">
      <input type="text" class="form-control" id="country" name="country" value="<?php echo $row['country']; ?>" />
    </div>
  </div>

  <div class="form-group">
    <label class="control-label col-sm-2" for="metascore">Metascore:</a></label>
    <div class="col-sm-10">
      <input type="text" class="form-control" id="metascore" name="metascore" />
    </div>
  </div>
  <div class="form-group">
    <label class="control-label col-sm-2" for="imdbRating">imdbRating:</a></label>
    <div class="col-sm-10">
      <input type="text" class="form-control" id="imdbRating" name="imdbRating" />
    </div>
  </div>

<?php if($_SESSION["ADMIN"] == "EDIT") {?> 
  <div class="form-group">
    <div class="col-sm-offset-2 col-sm-10">
      <button type="submit" class="btn btn-danger">Update Database</button> 
    </div>
  </div>
<?php } ?>

  </form>
</div>
