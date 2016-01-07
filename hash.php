<?php
if (!empty($_POST['pwd'])){

  require_once("db.php");

  $sql = "SELECT u.ID, u.User, u.Pass, u.Fav, ur.RoleID "
	. "  FROM _Users u LEFT JOIN _UserRoles ur "
	. "	ON u.ID = ur.UserID "
	 . "WHERE u.User='"
         . mysql_real_escape_string($_POST['user']) . "'"
	 . " ORDER BY ur.RoleID LIMIT 1";

  $result = mysql_query($sql);
  if (!$result) {
      die('Invalid query: ' . mysql_error());
  }

  while ($row = mysql_fetch_assoc($result)) {

    if (password_verify($_POST['pwd'], $row["Pass"])) {
	if($row["RoleID"] == 1){
	  $_SESSION["ADMIN"] = 1;
	  $_SESSION["UNRESTRICTED"] = 1;
	}
	else if($row["RoleID"] == 2){
	  $_SESSION["UNRESTRICTED"] = 1;
	}
	$_SESSION['user'] = $_POST['user'];
	$_SESSION['id'] = $row["ID"];
	if(!is_null($row["Fav"])){
	  $_SESSION['fav'] = $row["Fav"];
	}
	header('Location: vids.php'. $_SESSION['fav']);
    } else echo 'Invalid password.';
  }
}
?>
