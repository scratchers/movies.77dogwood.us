<?php
  include 'header.php';

  echo "Remote Addr: " . $_SERVER['REMOTE_ADDR'] . "<br/>";
  echo "Proxy: " . $_SERVER['HTTP_X_FORWARDED_FOR'] . "<br/>";

  include 'footer.php';
?>
