<?php
session_start();

include('inc/functions.php');
banned();
require_once('inc/session.php');
require_once('inc/config.php');
require_once('inc/html_grund.php');
include('cron.php');

$query_1    = mysql_query("SELECT COUNT(*) FROM clients ");
$item_count = mysql_result($query_1, 0);
$query_1    = mysql_query("SELECT * FROM clients ORDER BY id DESC");

$_SESSION['currentbots'] = mysql_num_rows(mysql_query("SELECT * FROM clients"));

echo '
	<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.3.2/jquery.min.js"></script>
	<script type="text/javascript" src="inc/stayontop.js"></script>
		
	<script type="text/javascript">
    	$(document).ready(function(){
      		refreshTable();
      		refreshBotsOnline();
    	});

    	function refreshTable(){
        	$(\'#tableHolder\').load(\'ajax.php\');
        	setTimeout(refreshTable, 5000);
    	}
    	
    	function refreshBotsOnline(){
        	$(\'#nav\').load(\'inc/html_menu.php\');
        	setTimeout(refreshBotsOnline, 5000);
    	}
	</script>
	
	<link rel="stylesheet" type="text/css" href="css/stylex.css"/>
	<div id="tableHolder"></div>';

require_once('inc/html_footer.php');
?>