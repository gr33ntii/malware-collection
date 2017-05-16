<?php
require_once('config.php');

$croncheck1 = mysql_query("SELECT * FROM clients WHERE status != 'Dead'");
$time       = time();
$hours      = 172800;

while ($row = mysql_fetch_array($croncheck1)) {
    $id            = $row['id'];
    $lasttime      = $row['time'];
    $processedtime = $time - $hours;
    if ($lasttime <= $processedtime) {
        mysql_query("UPDATE clients SET enabled = '0' WHERE id LIKE '$id'");
        mysql_query("UPDATE clients SET status = 'Dead' WHERE id LIKE '$id'");
    }
}

$croncheck2 = mysql_query("SELECT * FROM clients WHERE status LIKE 'Online'");
$time1      = time();
$mins       = 1800;

while ($row1 = mysql_fetch_array($croncheck2)) {
    $id1            = $row1['id'];
    $lasttime1      = $row1['time'];
    $processedtime1 = $time1 - $mins;
    if ($lasttime1 <= $processedtime1) {
        mysql_query("UPDATE clients SET status = 'Offline' WHERE id LIKE '$id1'");
    }
}

?>