<?php
session_start();
require_once('session.php');
require_once('config.php');

$online    = mysql_num_rows(mysql_query("SELECT * FROM clients WHERE status LIKE 'Online'"));
$offline   = mysql_num_rows(mysql_query("SELECT * FROM clients WHERE status LIKE 'Offline'"));
$dead      = mysql_num_rows(mysql_query("SELECT * FROM clients WHERE status LIKE 'Dead'"));
$hston     = mysql_num_rows(mysql_query("SELECT * FROM clients WHERE hst LIKE 'ON'"));
$hstof     = mysql_num_rows(mysql_query("SELECT * FROM clients WHERE hst LIKE 'OFF'"));
$pson      = mysql_num_rows(mysql_query("SELECT * FROM clients WHERE pos LIKE 'ON'"));
$psof      = mysql_num_rows(mysql_query("SELECT * FROM clients WHERE pos LIKE 'OFF'"));
$kyon      = mysql_num_rows(mysql_query("SELECT * FROM clients WHERE ky LIKE 'ON'"));
$kyof      = mysql_num_rows(mysql_query("SELECT * FROM clients WHERE ky LIKE 'OFF'"));
$x86       = mysql_num_rows(mysql_query("SELECT * FROM clients WHERE arc LIKE 'x86'"));
$x64       = mysql_num_rows(mysql_query("SELECT * FROM clients WHERE arc LIKE 'x64'"));
$totalbots = mysql_num_rows(mysql_query("SELECT * FROM clients"));
$full    = mysql_num_rows(mysql_query("SELECT * FROM clients WHERE fw LIKE 'Full'"));
$lite   = mysql_num_rows(mysql_query("SELECT * FROM clients WHERE fw LIKE 'Lite'"));
?>