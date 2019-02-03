<?php
$db['hostname'] = 'localhost';
$db['username'] = 'root';
$db['password'] = '';
$db['database'] = 'sarmiento-nuevo';

$link = mysql_connect($db['hostname'], $db['username'], $db['password'])
or die('No se pudo conectar: ' . mysql_error());;

mysql_select_db($db['database']) or die('No se pudo seleccionar la base de datos');

?>