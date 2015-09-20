<?php
if(!$_SERVER['HTTPS'])
    header('Location: https://' . $_SERVER['SERVER_NAME']);
if (session_status() == PHP_SESSION_NONE)
    session_start();
if(!isset($_SESSION['user']))
    header('Location: /');
?>
<!-- BEGIN POSTER DIV --><div>
<script>
function uploadPoster(mode){
  if(mode == "save")
    mode = "<?php echo $row['fname']; ?>";
  $.post( "getposter.php", { fname: mode, poster: $("#newposterurl").val() }, function(){
    loadPoster(mode);
  } );
}
function loadPoster(image){
  if(image == "orig"){
    $("#imgpos").attr("src", "posters/" + "<?php echo $row['fname']; ?>.jpg?" + new Date().getTime());
    $( "#newposterOrigbtn" ).removeClass( "btn-default" );
    $( "#newposterOrigbtn" ).addClass( "btn-success" );
    $( "#newposterTempbtn" ).removeClass( "btn-success" );
    $( "#newposterTempbtn" ).addClass( "btn-default" );
  }
  else {
    $("#imgpos").attr("src", "posters/" + image + ".jpg?" + new Date().getTime());
    $( "#newposterOrigbtn" ).removeClass( "btn-success" );
    $( "#newposterOrigbtn" ).addClass( "btn-default" );
    $( "#newposterTempbtn" ).removeClass( "btn-default" );
    $( "#newposterTempbtn" ).addClass( "btn-success" );
  }
}
</script>
<a id="vlcxspf" target='_blank' href='/xspf.php?fpath=<?php echo str_replace("'", "&#39;", $row["fpath"]); ?>'><img id="imgpos" class="img-responsive" src="posters/<?php echo $row['fname']; ?>.jpg" alt="No Poster Found"></img></a>

<?php if($_SESSION["ADMIN"] == "EDIT") {?>
<br/>
<div id="newposter">
  <a id="newposterOrigbtn" onclick="loadPoster('orig');" class="btn btn-success">Orig</a>
  <a id="newposterTempbtn" onclick="loadPoster('temp');" class="btn btn-default">Temp</a>
  <a id="newposterSavebtn" onclick="uploadPoster('save');" class="btn btn-primary">Save</a>
  <input type="URL" id="newposterurl"></input>
  <a id="newposterUploadbtn" onclick="uploadPoster('temp');" class="btn btn-default">Upload</a>
</div>
<?php } ?>
</div><!-- END POSTER DIV -->
