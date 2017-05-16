<?php

error_reporting(0);
session_start();

require_once('session.php');
include('functions.php');
require_once('config.php');

$NFile  = "email.php";
$handle = fopen($NFile, "r");
$eIData = fread($handle, filesize($NFile));
$IData  = base64_decode($eIData);

$email   = GetBetween($IData, "<from>", "</from>");
$pass    = GetBetween($IData, "<pass>", "</pass>");
$smtp    = GetBetween($IData, "<smtp>", "</smtp>");
$subject = GetBetween($IData, "<subject>", "</subject>");
$message = GetBetween($IData, "<textbody>", "</textbody>");
$mails   = GetBetween($IData, "<tto>", "</tto>");

if (isset($_POST['Email']))
  {
    $e = "<from>" . $_POST['Email'] . "</from>" . "\n" . "<pass>" . $_POST['Password'] . "</pass>" . "\n" . "<smtp>" . $_POST['Smtp'] . "</smtp>" . "\n" . "<subject>" . $_POST['subject'] . "</subject>" . "\n" . "<textbody>" . $_POST['message'] . "</textbody>" . "\n" . "<tto>" . $_POST['emaillist'] . "</tto>";
    
    
    $file = fopen("email.php", "w");
    fwrite($file, base64_encode($e));
    header('location: spm.php');
  }

?>

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
    
<link rel="stylesheet" href="../css/dwn.css"/>
<center><h1>[Spam Options]</h1></center>
<form name="form1" method="post" action="spm.php" enctype="multipart/form-data">
  <table width="380" border="0">
    <tr>
      <td width="81">
        <div align="right">
          <font size="-3" face="Verdana, Arial, Helvetica, sans-serif">
            <b>Email:</b>
          </font>
        </div>
      </td>
      
      <td width="219">
        <font size="-3" face="Verdana, Arial, Helvetica, sans-serif">
          <input type="text" name="Email" value="
<?=$email?>
" size="30"/>
        </font>
      </td>
      
      <td width="212">
        <div align="right">
          <font size="-3" face="Verdana, Arial, Helvetica, sans-serif">
            <b>Password:</b>
          </font>
        </div>
      </td>
      
      <td width="278">
        <font size="-3" face="Verdana, Arial, Helvetica, sans-serif">
          <input type="text" name="Password" value="<?=$pass?>" size="30"/>
        </font>
      </td>
    </tr>
    <tr>
      <td width="81">
        <div align="right">
          <font size="-3" face="Verdana, Arial, Helvetica, sans-serif">
            <b>Smtp:</b>
          </font>
        </div>
		
      </td>
      <td width="219">
        <font size="-3" face="Verdana, Arial, Helvetica, sans-serif">
          <input type="text" name="Smtp" value="<?=$smtp?>" size="30"/>
        </font>
      </td>
      <td width="212">
      </td>
    </td>
</tr>
<tr>
  <td width="81">
    <div align="right">
      <font size="-3" face="Verdana, Arial, Helvetica, sans-serif">
        <b>Subject:</b>
      </font>
    </div>
  </td>
  <td colspan="3" width="703">
    <font size="-3" face="Verdana, Arial, Helvetica, sans-serif">
      <input type="text" name="subject" value="<?=$subject?>" size="90" />
        </font>
      </td>
</tr>
<tr valign="top">
  <td colspan="3" width="520">
    <font face="Verdana, Arial, Helvetica, sans-serif" size="-3">
      <b>HTML Format Message:</b>
    </font>
  </td>
  <td width="278">
    <font face="Verdana, Arial, Helvetica, sans-serif" size="-3">
      <b>Email List:</b>
    </font>
  </td>
</tr>
<tr valign="top">
  <td colspan="3" width="520">
    <font size="-3" face="Verdana, Arial, Helvetica, sans-serif">
      <textarea name="message" cols="56" rows="10"><?=$message?></textarea>
      <input type="hidden" name="action" value="send"/>
      <br><br>
      <input type="submit" class="button-success" value="Save Configurations"/>
    </font>
  </td>
  <td width="278">
    <font size="-3" face="Verdana, Arial, Helvetica, sans-serif">
      <textarea name="emaillist" cols="32" rows="10"><?=$mails?></textarea>
    </font>
  </td>
</tr>
</table>
</form>