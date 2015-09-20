<?php
session_start();
if(!$_SESSION["ADMIN"]){
  header('Location: /');
}

include 'header.php';

if(isset($_POST["url"])){
  $tor = file_get_contents($_POST["url"]);
  file_put_contents("/var/lib/deluge/_watch/new.torrent",$tor);
}
?>

<div class="row">
<p>
<form class="form-inline" method="post" role="form">
  <div class="form-group">
    <label for="url"><a href="<?php echo $_SERVER['SCRIPT_NAME']; ?>" class="btn btn-default">Refresh</a></label>
    <input type="url" class="form-control" name="url" id="url"/>
    <button type="submit" class="btn btn-default">Submit</button>
  </div>
</form>
<p>
</div>

<div class="row">
<div class='col-md-6'>
  <iframe src='/deluge/_watch/' style='width:100%; height:400px'></iframe>
</div>
<div class='col-md-6'>
  <iframe src='/deluge/' style='width:100%; height:400px'></iframe>
</div>
</div>

<?php include 'footer.php'; ?>
