<?php
session_start();

include('inc/functions.php');
banned();
require_once('inc/session.php');
require_once('inc/config.php');

$cmd = $_GET['cmd'];

if ($cmd == "download")
  {
    download_file('reports.zip');
  }

if ($cmd == 'compress')
  {
    compress($folder.'/', 'reports.zip', false, true);
    header("Location: dwn.php");
  }

if ($cmd == 'delete')
  {
    @unlink('reports.zip');
    echo '<p align="center" style="color:green">All done!, You can close this window</p>';
  }

?>

<link rel="stylesheet" href="css/dwn.css"/>

<table width="100%">
  <tr>
    <td align="center">
      <a href="dwn.php?cmd=download" class="btn btn-green">
        Download
      </a>
    </td>
  </tr>
  <tr>
    <td align="center">
      <a href="dwn.php?cmd=delete" class="btn btn-red">
        &nbsp;Delete&nbsp;
      </a>
    </td>
  </tr>
  <tr>
    <td align="center">
      After download your file, please dont forget delete it for security reasons.
    </td>
  </tr>
  <table>