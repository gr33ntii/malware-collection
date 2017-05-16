<?php

$port=isset($data['s4'])?(float)$data['s4']:0;
if($port)
	{
	$qres=@mysql_query("SELECT id FROM socks4 WHERE id=$id LIMIT 1");
	switch(mysql_num_rows($qres))
		{
		case 0:
			@mysql_query("INSERT INTO socks4 SET id=$id, port=$port");
			break;
		case 1:
			@mysql_query("UPDATE socks4 SET port=$port WHERE id=$id LIMIT 1");
			break;
		}
	}

?>