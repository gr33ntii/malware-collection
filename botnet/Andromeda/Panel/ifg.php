<?php

include("./config.php");
if(!@mysql_connect($settings['mysql_host'],$settings['mysql_user'],$settings['mysql_pass'])){die("<p style=\"font-family:Lucida Console; font-size:11px;\">ERROR: mysql login failed.</p>");}
if(!@mysql_select_db($settings['mysql_db'])){die("<p style=\"font-family:Lucida Console; font-size:11px;\">ERROR: can't select db '$settings[mysql_db]'</p>");}

mysql_query("DROP TABLE IF EXISTS fg");
mysql_query("CREATE TABLE fg (id INT UNSIGNED NOT NULL PRIMARY KEY AUTO_INCREMENT, rule VARCHAR(512) NOT NULL, enabled TINYINT UNSIGNED NOT NULL)") or die(mysql_error());
die("<pre style=\"font-family:Lucida Console; font-size:11px;\">Table for formgrabber successfully created.</pre>");

?>