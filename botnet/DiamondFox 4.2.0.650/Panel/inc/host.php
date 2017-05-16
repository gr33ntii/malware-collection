<?php
session_start();
error_reporting(0);

require_once('session.php');
require_once('config.php');
include('functions.php');

if (isset($_POST['Host']))
  {
    $Data = base64_encode($_POST['Host']);
    $file = fopen("read.php", "w");
    fwrite($file, $Data);
    header('location: host.php');
  }

$NFile  = "read.php";
$handle = fopen($NFile, "r");
$IData  = fread($handle, filesize($NFile));


echo '

<style scoped>
 .button-success
  {
   color: white;
   border-radius: 4px;
   text-shadow: 0 1px 1px rgba(0, 0, 0, 0.2);
  }

 .button-success 
  {
   background: rgb(28, 184, 65); /* this is a green */
  }
</style>

<link rel="stylesheet" href="../css/sbody.css">
	<div id="form-container"> 
			<form action="host.php" method="POST">
				<p align="center">
				   <font size="6"><b>[DNS Redirects]</b></font>
				   <br>
				   <tt><font size="3">Enter the redirects in the following format:</font>
				   <br>
				   <font size="3">&lt;IP to Redirect&gt; &lt;Original IP&gt;</font>
				   <br>
				   <font size="3">Example: 127.0.0.1 localhost</font></tt>
				   <br>
				   <textarea rows="15" name="Host" cols="250" style="width:90%; text-align:left;">' . base64_decode($IData) . '</textarea>
				   <br><input class="button-success" type="submit" value="Save Configurations"; name="B1">
				</p>	
			</form>
		</div>';

?>