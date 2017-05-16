<?php

$id=(float)$_GET["id"];

if($act=="fg")
	{
	define("FG_RULE_FORM","<form method=\"post\" action=\"?act=fg&subact=<php:subact><php:id>\"><table cellspacing=0 width=100%><tr><td align=\"right\" style=\"padding-right:10px; padding-top:10px\"><font>URL (regexp):</font></td><td style=\"padding-top:10px\"><input type=\"text\" maxlength=255 style=\"width:530px;\" name=\"rule\" value=\"<php:rule>\"></td></tr><tr><td></td><td><input type=\"checkbox\" name=\"enabled\"<php:checked>><font>Enabled</font></td></tr><tr><td></td><td><input type=\"submit\" class=\"i_submit\" value=\"<php:submit>\"></td></tr></table></form>");
	$dyn="<tr><td class=\"me\"><a class=\"mt\" href=\"?act=fg&subact=add\">Add rule</a></td></tr>";
	$dyn.="<tr><td class=\"me\"><a class=\"mt\" href=\"?act=fg&subact=delall\" onclick=\"return confirm('Are you sure?');\">Delete ALL rules</a></td></tr>";
	$left_menu.=str_replace("<php:caption>","Actions",MENU);
	$left_menu=str_replace("<php:content>",$dyn,$left_menu);

	unset($break);
	switch($subact)
		{
		case "add":
			$rule=mysql_escape_string(htmlspecialchars($_POST["rule"],ENT_QUOTES));
			$enabled=isset($_POST["enabled"])?1:0;
			if(!empty($rule))
				{
				mysql_query("INSERT INTO fg SET rule='$rule', enabled=$enabled") or die(mysql_error());
				$content="<div class=\"mess\"><font style=\"font-weight:bold\">Rule successfully added.</font></div>";
				}
				else
				{
				$content=str_replace("<php:caption>","Add new rule",WINDOW);
				$content=str_replace("<php:width>","700",$content);
				
				$form=str_replace("<php:subact>","add",FG_RULE_FORM);
				$form=str_replace("<php:checked>","",$form);
				$form=str_replace("<php:id>","",$form);
				$form=str_replace("<php:rule>","",$form);
				
				$form=str_replace("<php:submit>","Add",$form);
				$content=str_replace("<php:content>",$form,$content);
				$break=true;
				}
			break;
		case "edit":
			$rule=mysql_escape_string(htmlspecialchars($_POST["rule"],ENT_QUOTES));
			$enabled=isset($_POST["enabled"])?1:0;	
			if(!empty($rule))
				{
				mysql_query("UPDATE fg SET rule='$rule', enabled=$enabled WHERE id=$id LIMIT 1") or die(mysql_error());
				$content="<div class=\"mess\"><font style=\"font-weight:bold\">Rule #$id successfully updated.</font></div>";
				}
				else
				{
				$qres=mysql_query("SELECT * FROM fg WHERE id=$id LIMIT 1");
				$row=mysql_fetch_assoc($qres) or die(mysql_error());

				$content=str_replace("<php:caption>","Edit #$id rule",WINDOW);
				$content=str_replace("<php:width>","700",$content);
				
				$form=str_replace("<php:subact>","edit",FG_RULE_FORM);
				if($row["enabled"]){$form=str_replace("<php:checked>"," checked",$form);}else{$form=str_replace("<php:checked>","",$form);}
				$form=str_replace("<php:id>","&id=".$id,$form);
				$form=str_replace("<php:rule>",$row["rule"],$form);
				
				$form=str_replace("<php:submit>","Edit",$form);
				$content=str_replace("<php:content>",$form,$content);
				$break=true;
				}
			break;
		case "del":
			mysql_query("DELETE FROM fg WHERE id=$id LIMIT 1") or die(mysql_error());
			$content="<div class=\"mess\"><font style=\"font-weight:bold\">Rule #$id deleted.</font></div>";
			break;
		case "re":
			mysql_query("UPDATE fg SET enabled=NOT(enabled) WHERE id=$id LIMIT 1") or die(mysql_error());
			$content="<div class=\"mess\"><font style=\"font-weight:bold\">Rule #$id re-enabled.</font></div>";			
			break;
		case "delall":
			mysql_query("DELETE FROM fg") or die(mysql_error());
			$content="<div class=\"mess\"><font style=\"font-weight:bold\">All rules deleted.</font></div>";
			break;	
		}
	if(!$break)
		{
		unset($dyn);
		$qres=mysql_query("SELECT * FROM fg ORDER BY id") or die(mysql_error());
		
		if(mysql_num_rows($qres)!=0)
			{
			$back=false;
			while($row=mysql_fetch_assoc($qres))
				{
				if($back){$dyn.="<tr style=\"background-color:#FFFFB4\">";}else{$dyn.="<tr style=\"background-color:White\">";}
				$back=!$back;
				
				$rule=empty($row["rule"])?"&nbsp":$row["rule"];
				
				$dyn.="<td class=\"te\" style=\"text-align:center; padding:0px\"><font>$row[id]</font></td>";
				$dyn.="<td class=\"te\"><font>$rule</font></td>";
				
				$dyn.="<td class=\"te\" style=\"background-color:";
				if($row["enabled"])
					{$dyn.="LightGreen; text-align:center;\"><font>True</font></td>";}
				else
					{$dyn.="LightCoral; text-align:center;\"><font>False</font></td>";}
				
				$dyn.="<td class=\"tel\">";
				$dyn.="<a href=\"?act=fg&subact=edit&id=$row[id]\">[edit]</a><font>&nbsp</font>";
				$dyn.="<a href=\"?act=fg&subact=re&id=$row[id]\">[on/off]</a><font>&nbsp</font>";
				$dyn.="<a href=\"?act=fg&subact=del&id=$row[id]\" style=\"color:red;\">[delete]</a>";
				$dyn.="</td></tr>";
				}
			$content.="<table cellspacing=0 width=100%><tr><th width=10px class=\"th\"><font>#</font></th><th class=\"th\"><font>URL (RegExp)</font></th><th width=50px class=\"th\"><font>Enabled</font></th><th width=130px class=\"thl\"><font>Actions</font></th></tr>$dyn</table>";
			}
			else{$content="<div class=\"mess_err\"><font style=\"font-weight:bold\">The database table is empty.</font></div>".$content;}
		}
	$parsed=true;
	}
?>