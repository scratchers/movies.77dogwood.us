<?php
  include 'header.php';
  require_once("db.php");

  $sql = "SELECT (CASE WHEN l.flag IS NULL THEN '<strong style=''color: red;''>NEW</strong>' ELSE l.flag END) AS flag, a.IP, COUNT(a.IP) AS Cnt, MAX(Time) AS LastTime FROM __Access a LEFT JOIN __AccessList l ON a.IP = l.IP GROUP BY a.IP ORDER BY ";

  if($_GET['f'] == 1)
	$sql .= "flag";
  elseif($_GET['f'] == 2)
        $sql .= "flag DESC";
  elseif($_GET['i'] == 1)
        $sql .= "a.IP";
  elseif($_GET['i'] == 2)
        $sql .= "a.IP DESC";
  elseif($_GET['c'] == 1)
        $sql .= "Cnt";
  elseif($_GET['c'] == 2)
        $sql .= "Cnt DESC";
  elseif($_GET['t'] == 1)
        $sql .= "LastTime";
  elseif($_GET['t'] == 2)
        $sql .= "LastTime DESC";
  else
	$sql .= "LastTime DESC";

  $result = mysql_query($sql);
  if (!$result) {
      die('Invalid query: ' . mysql_error());
  }

?>
 <div class='col-xs-12 col-md-6'>
  <table class="table table-striped table-bordered table-condensed">
    <thead>
      <tr>
        <th><a href="?f=1">Flag</a></th>
        <th><a href="?i=1">IP</a></th>
        <th><a href="?c=1">Cnt</a></th>
	<th><a href="?t=1">LastTime</a></th>
      </tr>
    </thead>
    <tbody>
<?php
  echo "<tr><td></td><td>Total</td><td>" . mysql_num_rows($result) . "</td><td></td></tr>";
  while ($row = mysql_fetch_assoc($result)) {
?>
      <tr>
	<td><?php echo $row['flag']; ?></td>
        <td><?php echo $row['IP']; ?></td>
        <td><?php echo $row['Cnt']; ?></td>
        <td><?php echo $row['LastTime']; ?></td>
      </tr>

<?php
  }
  echo "</tbody></table></div>";
  include 'footer.php';
?>
