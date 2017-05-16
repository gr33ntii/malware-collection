<?php
session_start();
require_once('session.php');

require_once('config.php');

$query_1    = mysql_query("SELECT COUNT(*) FROM clients ");
$item_count = mysql_result($query_1, 0);
$query_1    = mysql_query("SELECT * FROM clients ORDER BY id DESC LIMIT 1");
$row        = mysql_fetch_array($query_1);
echo '<div id="ajaxdiv" style="width:100%; padding: 10px; background:#d5f3ff"><a><center>&nbsp;New User Online: ';
echo $row['userandpc'];
echo '</center></a></div>';
?>