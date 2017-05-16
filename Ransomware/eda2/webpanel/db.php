
<?php

$connection = new PDO('mysql:host=mysql.hostinger.vn;dbname=u542520938_xolzs;charset=utf8', 'u542520938_xolzs', '12782389');
$connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
$q = $connection->query('SELECT * FROM dummy');
?>