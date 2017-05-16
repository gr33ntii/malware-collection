<?php
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
?>